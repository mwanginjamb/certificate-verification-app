<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Program;
use yii\filters\VerbFilter;

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
                // save the data
                $this->saveData($sheetData);
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

    private function saveData($sheetData)
    {
        $ImportedAccounts = Certificates::find()->select(['certificate_id'])->AsArray()->all();

        /*print '<pre>';
        print_r($sheetData);
        exit;*/
        $today = date('Y-m-d');
        $rowOffset = 2;
        foreach ($sheetData as $key => $data) {
            // Read from 3rd row
            if ($key >= 3) {
                if (trim($data['C']) !== '') {
                    $model = new Certificates();

                    // Try find an existing model for Update

                    $accountModel = Certificates::findOne(['certificate_id' => $data['C']]);


                    if ($accountModel && $accountModel->AccountNumber == $data['C']) {



                        $accountModel->AccountName = $data['D'];
                        $accountModel->AccountNumber =  $data['C'];
                        $accountModel->BankID = (trim($data['E'])  !== '' && $this->getBankID($data['E'])) ? $this->getBankID($data['E']) : 0;
                        $accountModel->BranchID =  (trim($data['F']) !== '' && $this->getBranchID($data['F'])) ? $this->getBranchID($data['F']) : 0;
                        $accountModel->BankTypeID = (trim($data['G']) !== '' && $this->getBankTypeID($data['G'])) ? $this->getBankTypeID($data['G']) : 0;
                        $accountModel->Notes = (trim($data['H']) !== '') ? $data['H'] : '';
                        $accountModel->CountyID = (trim($data['I']) !== '' && $this->getCountyID($data['I'])) ? $this->getCountyID($data['I']) : 0;
                        $accountModel->CommunityID = (trim($data['J']) !== '' && $this->getCommunityID($data['J'])) ? $this->getCommunityID($data['J']) : 0;
                        $accountModel->ProjectID = (trim($data['K']) !== '' && $this->getProjectID($data['K'])) ? $this->getProjectID($data['K']) : 0;
                        $accountModel->CreatedBy = Yii::$app->user->identity->UserID;
                        $accountModel->CreatedDate = $today;

                        if (!$accountModel->save()) {
                            foreach ($accountModel->errors as $k => $v) {
                                Yii::$app->session->setFlash('error', $v[0] . ' <b>Update Error :Got value</b>: <i><u>' . $accountModel->$k . '</u> <b>for Account Name:' . $data['C'] . '</b> - On Row:</b>  ' . ($key - $rowOffset));
                            }
                        } else {
                            Yii::$app->session->setFlash('success', 'Congratulations, all valid records are completely updated .');
                        }
                    } else {

                        if (in_array($data['C'], $ImportedAccounts)) {
                            continue;
                        }

                        $model->AccountName = $data['D'];
                        $model->AccountNumber =  $data['C'];
                        $model->BankID = (trim($data['E'])  !== '' && $this->getBankID($data['E'])) ? $this->getBankID($data['E']) : 0;
                        $model->BranchID =  (trim($data['F']) !== '' && $this->getBranchID($data['F'])) ? $this->getBranchID($data['F']) : 0;
                        $model->BankTypeID = (trim($data['G']) !== '' && $this->getBankTypeID($data['G'])) ? $this->getBankTypeID($data['G']) : 0;
                        $model->Notes = (trim($data['H']) !== '') ? $data['H'] : '';
                        $model->CountyID = (trim($data['I']) !== '' && $this->getCountyID($data['I'])) ? $this->getCountyID($data['I']) : 0;
                        $model->CommunityID = (trim($data['J']) !== '' && $this->getCommunityID($data['J'])) ? $this->getCommunityID($data['J']) : 0;
                        $model->ProjectID = (trim($data['K']) !== '' && $this->getProjectID($data['K'])) ? $this->getProjectID($data['K']) : 0;
                        $model->CreatedBy = Yii::$app->user->identity->UserID;
                        $model->CreatedDate = $today;
                    }

                    if (!$model->save()) {
                        foreach ($model->errors as $k => $v) {
                            Yii::$app->session->setFlash('error', $v[0] . ' <b>Got value</b>: <i><u>' . $model->$k . '</u> <b>for Account Name:' . $data['C'] . '</b> - On Row:</b>  ' . ($key - $rowOffset));
                        }
                    } else {
                        Yii::$app->session->setFlash('success', 'Congratulations, all valid records are completely imported into MIS.');
                    }
                }
            }
        }


        return $this->redirect(['index']);
    }
}
