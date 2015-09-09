<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */
$this->title = 'Вiдновлення паролю';
$this->params['breadcrumbs'][] = $this->title;
?>



<div id="pass-recovery" class="popup popup_pass-recovery">
    <div class="popup-inside popup_pass-recovery__in">
        <div class="nd-popup-head">
            <?= Html::encode($this->title) ?>
        </div>
        <?php if (Yii::$app->session->hasFlash("success_reset")): ?>
            <div class="popup-form tcenter" id="success">
                <p>На вашу електронну пошту<br/>надіслано підтвердження</p>
            </div>
        <?php else: ?>
            <?php $form = ActiveForm::begin([
                'id' => 'request-password-reset-form',
                'method' => 'post',
                'options' => [
                    'class' => "popup-form tcenter"
                ]
            ]);
            ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'email']) ?>
            <div class="form-group">
                <?= Html::submitButton('Надіслати', ['class' => 'popup__yellow-btn', 'id' => 'thanks']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
</div>
