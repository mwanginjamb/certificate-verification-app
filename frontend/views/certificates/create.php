<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Certificates $model */

$this->title = Yii::t('app', 'Create Certificates');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
