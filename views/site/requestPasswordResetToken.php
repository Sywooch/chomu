<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */
$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="pass-recovery" class="nd-popup">
    <div class="popup-inside">
        <div class="nd-popup-head">
            <?= Html::encode($this->title) ?>
        </div>
        <form class="popup-form tcenter" > 
            <?php $form = ActiveForm::begin([
                'id' => 'request-password-reset-form'
                ]); 
            ?>
                <?= $form->field($model, 'email') ?>
                <div class="form-group">
                    <?= Html::submitButton('Надіслати', ['class' => 'popup__yellow-btn']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </form>
    </div>
</div>