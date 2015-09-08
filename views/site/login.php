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

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>
            <div class="pass-reminder"><a href="/reset.html">Забули пароль?</a></div>

            <!--<?= $form->field($model, 'rememberMe', [
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->checkbox() ?>-->


            <?= Html::submitButton('Логiн', ['class' => 'popup__yellow-btn', 'name' => 'login-button']) ?>


            <?php ActiveForm::end(); ?>

           <!--  <div class="col-lg-offset-1" style="color:#999;">
                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                To modify the username/password, please check out the code <code>app\models\User::$users</code>.
            </div> -->
        </div>
    </div>
</div>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div id="email-signup__success" class="nd-popup">
        <div class="popup-inside">
            <button class="popup__close"></button>
            <div class="nd-popup-head">
                Реєстрація<br/>пройшла успішно. <br/><br/>
                Ваш голос прийнято!
            </div>

        </div>
    </div>
    <style>
        #email-signup__success{

            position: fixed;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: 90px auto;
            padding: 110px 110px;
            z-index: 99;
        }
    </style>
    <script>
        $(window).ready(function(){
            $('#email-signup__success').fadeOut(4000);
        });
    </script>
<?php endif; ?>
