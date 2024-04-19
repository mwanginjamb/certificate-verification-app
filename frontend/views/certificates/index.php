<?php

use common\models\Certificates;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\CertificatesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Certificates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Certificates'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => LinkPager::class,
            'options' => ['class' => 'pagination justify-content-end'],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'certificate_id',
            'program_id',
            [
                'label' => 'Program Description',
                'value' => function ($model) {
                    return $model->program->name;
                }
            ],
            'student_name',
            'issue_date:datetime',
            'created_at:datetime',
            //'updated_at',
            //'updated_by',
            //'created_by',
            //'deleted_at',
            //'deleted_by',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Certificates $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>