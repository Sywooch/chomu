<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */
$this->title = 'Скинути пароль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="pass-recovery" class="popup popup_pass-recovery">
    <div class="popup-inside popup_pass-recovery__in">
        <div class="nd-popup-head">
            <?= Html::encode($this->title) ?>
        </div>
        <?php $form = ActiveForm::begin([
                'id' => 'reset-password-form',
                'options' => [
                    'class' => 'tcenter popup-form cssFormClassName'
                ]
            ]); ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
