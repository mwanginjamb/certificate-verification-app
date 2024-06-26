<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Program $model */

$this->title = Yii::t('app', 'Create Program');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Programs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
