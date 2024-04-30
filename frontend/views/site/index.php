<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;
$logo = Yii::getAlias('@web/images/kemri-logo.png');
?>

<div class="container w-75">
    <section class="mt-5 mb-3 mx-auto d-flex flex-column justify-content-center align-items-center ">
        <img src="<?= $logo ?>" alt="" class="logo" width="150">
        <p class="text-muted">KEMRI GRADUATE SCHOOL CERTIFICATES VERIFICATION PORTAL.</p>
    </section>
    <form action="<?= Url::toRoute(['certificates/verify'], $schema = true) ?>" method="post" class="mt-4">
        <div class="input-group mb-3">
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
            <input type="text" autocomplete="off" required class="form-control form-control-lg" name="serial" placeholder="Enter Certificate number to verify.">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

</div>
<?php
$bg = Yii::getAlias('@web/images/kemri_personal_info.svg');
$style = <<<CSS
.showcase {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 250px; /* Adjust image height as needed */
      background: #ccc;
      background-image: url("$bg");
      background-size: contain;
      background-position: center;
     
    }
CSS;

$this->registerCss($style);
