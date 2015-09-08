<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="email-login" class="popup popup_email-signup " style="">
    <div class="popup-inside"> 
        <button class="popup__close"></button>
        <div class="site-login">
            <div class="nd-popup-head"><?= Html::encode($this->title) ?></div>

            <p>Please fill out the following fields to login:</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'popup-form form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe', [
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->checkbox() ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <div class="pass-reminder"><a href="/reset.html">Забули пароль?</a></div>



            <div class="col-lg-offset-1" style="color:#999;">
                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                To modify the username/password, please check out the code <code>app\models\User::$users</code>.
            </div>
        </div>
    </div>
</div>

