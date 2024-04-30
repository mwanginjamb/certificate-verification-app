<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1 class="display-5"><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php
    if (Yii::$app->session->hasFlash('success') && is_string(Yii::$app->session->getFlash('success'))) {
        print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
        echo Yii::$app->session->getFlash('success');
        print '</div>';
    } else if (Yii::$app->session->hasFlash('error') && is_string(Yii::$app->session->getFlash('error'))) {
        print ' <div class="alert alert-danger alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
        echo Yii::$app->session->getFlash('error');
        print '</div>';
    }
    ?>


    <div class="row">
        <div class="col-lg-8">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?php $form->errorSummary($model) ?>

            <?= Html::hiddenInput(['autocomplete' => false]) ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="auth-links d-flex justify-content-between my-2">

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                <div class="py-auto my-auto">
                    Create an Account? <?= Html::a('Signup', ['site/signup'], ['class' => 'text-primary fw-bold']) ?>
                </div>
            </div>

            <div class="row">
                <div class="p-2 text-sm col-md-6">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset'], ['class' => 'text-info fw-bold']) ?>.
                </div>
                <div class="p-2 text-sm col-md-6">
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email'], ['class' => 'text-warning fw-bold']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>