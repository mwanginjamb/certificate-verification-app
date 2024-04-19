<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Certificates $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$program = $model->program;
?>
<div class="certificates-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            // 'program_id',
            'student_name',
            'issue_date:datetime',
            // 'created_at',
            // 'updated_at',
            // 'updated_by',
            //  'created_by',
            //  'deleted_at',
            //  'deleted_by',
        ],
    ]) ?>


    <section-program class="my-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Program Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="fw-bold">Name</td>
                            <td><?= $program->name ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Description</td>
                            <td><?= $program->description ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Start Date</td>
                            <td><?= Yii::$app->formatter->asDatetime($program->start_date) ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">End Date</td>
                            <td><?= Yii::$app->formatter->asDatetime($program->end_date) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section-program>

</div>