<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 12/20/2021
 * Time: 5:29 PM
 */

use yii\boostrap5\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Communities */

$this->title = 'Batch Import Certificates via Excel Template';
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="flexbox-container">

    <?= $this->render('_excelform', [
        'model' => $model,

    ]) ?>

</section>