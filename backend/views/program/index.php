<?php

use common\models\Program;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\ProgramSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Programs');
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->session->hasFlash('success')) {
    print ' <div class="alert alert-success alert-dismissable role="alert">
                             <button type="button"  class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                             <h5><i class="bi bi-check-circle"></i> Success!</h5>
 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
} else if (Yii::$app->session->hasFlash('error')) {
    print ' <div class="alert alert-danger alert-dismissable role="alert">
                                 <button type="button"  class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                                 <h5><i class="bi bi-x-circle"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>
<div class="program-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Program'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class, // Use Bootstrap 5 pager
        ],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            'description:ntext',
            'start_date',
            'end_date',
            //'created_at',
            //'updated_at',
            //'updated_by',
            //'created_by',
            //'deleted_at',
            //'deleted_by',
            [
                'class' => ActionColumn::class,
                /*'urlCreator' => function ($action, Program $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }*/
                'template' => '{view} {update} {delete} {load}',
                'buttons' => [
                    'load' => function ($url, $model, $key) {
                        $url = Url::to(['excel-import', 'programID' => $model->id]);
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383"/>
  <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708z"/>
</svg>';

                        return Html::a($icon, $url, [
                            'title' => 'Batch Upload Verifiable Certificate details for this program',
                            'data' => [
                                'method' => 'POST'
                            ]
                        ]);
                    }
                ],

            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>