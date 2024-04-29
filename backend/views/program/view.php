<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\Program $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Programs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

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
<div class="program-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Import Certificates'), ['excel-import', 'programID' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Download Certificates Template'), ['download'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'description:ntext',
            'start_date:date',
            'end_date:date',
            'created_at:datetime',
            'updated_at:datetime',
            // 'updated_by',
            // 'created_by',
            // 'deleted_at',
            // 'deleted_by',
        ],
    ]) ?>

    <?php if ($model->certificates) : ?>
        <div class="p text fw-bold display-4 my-3">Issued Certificates</div>
        <table class="table table-bordered" id="certs">

            <thead>
                <tr>
                    <td class="fw-bold">Participant Name</td>
                    <td class="fw-bold">Issue Date</td>
                    <td class="fw-bold">Certificate ID</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model->certificates as $cert) : ?>
                    <tr>
                        <td><?= $cert->student_name ?></td>
                        <td><?= Yii::$app->formatter->asDate($cert->issue_date, 'medium') ?></td>
                        <td><?= $cert->certificate_id ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-info">No certificated issued yet for this program. Use the <b>downloadable</b> template above to import some.</div>
    <?php endif; ?>

</div>

<?php

$js = <<<JS
  $('#certs').DataTable();
JS;
$this->registerJs($js);
