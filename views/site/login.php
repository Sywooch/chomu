<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Логiн';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="email-signin" class="popup popup_email-signin " style="">
    <div class="popup-inside"> 
        <button class="popup__close" onclick="window.location.href = '/'"></button>
        <div class="site-login tcenter">
            <div class="nd-popup-head"><?= Html::encode($this->title) ?></div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',

                'options' => ['class' => 'popup-form form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel( 'email' )]) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel( 'password' )]) ?>
            <div class="pass-reminder"><a href="/reset.html">Забули пароль?</a></div>

            <!--<?= $form->field($model, 'rememberMe', [
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->checkbox() ?>-->

            <?= Html::submitButton('Увійти', ['class' => 'popup__yellow-btn', 'name' => 'login-button']) ?>


            <?php ActiveForm::end(); ?>

           <!--  <div class="col-lg-offset-1" style="color:#999;">
                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                To modify the username/password, please check out the code <code>app\models\User::$users</code>.
            </div> -->
        </div>
    </div>
</div>

