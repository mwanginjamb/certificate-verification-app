<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = Yii::$app->name;
?>

<div class="container w-75">
    <section class="mt-5 mb-3 mx-auto d-flex flex-column justify-content-center align-items-center ">
        <img src="<?= Url::to('@web/images/kemri-logo.png') ?>" alt="" class="logo" width="150">
        <p class="text">KEMRI GRADUATE SCHOOL CERTIFICATES VERIFICATION PORTAL.</p>
    </section>

    <div class="row col col-md-12">
        <div class="col-md-6">
            <h3 class="text text-primary fw-bold my-3">Program</h3>
            <table class="table table-bordered">
                <tr>
                    <td class="fw-bold">Program</td>
                    <td><?= $result->program->name ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Description</td>
                    <td><?= $result->program->description ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Start Date</td>
                    <td><?= $result->program->start_date ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">End Date</td>
                    <td><?= $result->program->end_date ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h3 class="text text-primary fw-bold my-3">Certificate Details</h3>
            <table class="table table-bordered">
                <tr>
                    <td class="fw-bold">Name</td>
                    <td><?= $result->student_name ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Certificate Issue Date</td>
                    <td><?= $result->issue_date ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Certificate ID</td>
                    <td><?= $result->certificate_id ?></td>
                </tr>

            </table>
        </div>
    </div>

</div>
<?php
$bg = Url::home(true) . 'images/kemri_inspection.svg';
$style = <<<CSS
.showcase {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 250px; /* Adjust image height as needed */
      background: #ccc;
      background-image: url($bg);
      background-size: contain;
      background-position: center;
     
    }
CSS;

$this->registerCss($style);
