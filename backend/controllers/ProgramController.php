<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Program;

use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use common\models\Certificates;
use common\models\ProgramSearch;
use yii\web\NotFoundHttpException;
use common\models\CertificateImport;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * ProgramController implements the CRUD actions for Program model.
 */
class ProgramController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'only' => [
                        'index', 'create', 'update', 'delete', 'view', 'verify'
                    ],
                    'rules' => [
                        [ // unauthenticated users
                            'actions' => ['signup', 'verify'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [ // logged in users
                            'actions' => ['index', 'create', 'update', 'delete', 'view'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all Program models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProgramSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Program model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Program model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Program();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Program model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Program model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Program model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Program the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Program::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    // Batch Data Import

    public function actionExcelImport($programID)
    {
        $model = new  CertificateImport();
        $model->programID = $programID = $programID;
        return $this->render('import', ['model' => $model]);
    }

    public function actionImport()
    {
        $model = new CertificateImport();
        if ($model->load(Yii::$app->request->post())) {
            $excelUpload = UploadedFile::getInstance($model, 'excel_doc');
            $model->excel_doc = $excelUpload;
            if ($uploadedFile = $model->upload()) {
                // Extract data from  uploaded file
                $sheetData = $this->extractData($uploadedFile);
                unlink($uploadedFile);
                // save the data
                $this->saveData($sheetData, $model->programID);
            } else {
                $this->redirect(['excel-import']);
            }
        } else {
            $this->redirect(['excel-import']);
        }
    }

    private function extractData($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
    }

    private function saveData($sheetData, $programID)
    {

        $Importedcertificates = ArrayHelper::index(Certificates::find()->select(['certificate_id'])->where(['program_id' => $programID])->AsArray()->all(), 'certificate_id');
        $existing = array_keys($Importedcertificates);

        $rowOffset = 1;

        $filteredArray = array_filter($sheetData, function ($item) use ($existing) {
            return !in_array($item['C'], $existing) && !is_null($item['C']);
        });


        foreach ($filteredArray as $key => $data) {
            // Read from 2nd row
            if ($key !== 1) {
                if (!is_null($data['A'])) {

                    $model = new Certificates();

                    $model->program_id = $programID;
                    $model->student_name = $data['A'] ?? '';
                    $model->issue_date = $data['B'] ?? '';
                    $model->certificate_id = $data['C'] ?? '';

                    if (!$model->save()) {
                        foreach ($model->errors as $k => $v) {
                            Yii::$app->session->setFlash('error', $v[0] . ' <b>Got value</b>: <i><u>' . $model->$k . '</u> <b>for certificate Name:' . $data['C'] . '</b> - On Row:</b>  ' . ($key - $rowOffset) . '  ' . $data['A']);
                        }
                    } else {
                        Yii::$app->session->setFlash('success', 'Congratulations, all valid records are completely imported into the system.');
                    }
                }
            }
            if (count($existing)) {
                Yii::$app->session->setFlash('error', count($existing) . ' duplication conflicts were found on your import.');
            }
        }


        return $this->redirect(['view', 'id' => $programID]);
    }
    public function actionDownload()
    {
        // Define the path to the template file
        $templateFilePath = Yii::getAlias('@webroot/templates/template.xlsx');

        // Check if the file exists before proceeding
        if (file_exists($templateFilePath)) {
            // Set response headers for file download
            Yii::$app->response->sendFile($templateFilePath, 'template.xlsx', [
                'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]);
        } else {
            // Handle the case where the template file doesn't exist
            Yii::$app->session->setFlash('error', 'Template file not found.');
            // Redirect or display an error message
            Yii::$app->getResponse()->redirect(['program/index']);
        }
    }
}
