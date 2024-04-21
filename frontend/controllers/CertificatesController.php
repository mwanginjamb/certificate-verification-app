<?php

namespace frontend\controllers;

use common\models\CertificateImport;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Certificates;
use yii\web\NotFoundHttpException;
use common\models\CertificatesSearch;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * CertificatesController implements the CRUD actions for Certificates model.
 */
class CertificatesController extends Controller
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
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'verify' => ['POST'],
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
     * Lists all Certificates models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CertificatesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 15;
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Certificates model.
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

    public function actionVerify()
    {
        $this->layout = 'plain';
        $searchId = Yii::$app->request->post('serial');
        $results = Certificates::find()->with('program')->where(['certificate_id' => $searchId])->one();
        if ($results) {
            Yii::$app->session->setFlash('success', 'Certificate is valid and below are the regitimate details. ');
        } else {
            Yii::$app->session->setFlash('error', 'Certificate number doe not represent a validly issued certificate at KGS. ');
        }

        return $this->render('verify', [
            'result' => $results
        ]);
    }

    /**
     * Creates a new Certificates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Certificates();

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
     * Updates an existing Certificates model.
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
     * Deletes an existing Certificates model.
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
     * Finds the Certificates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Certificates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Certificates::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
