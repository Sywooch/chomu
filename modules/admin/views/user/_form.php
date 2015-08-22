<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\User;
use app\modules\admin\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?php $name =  Profile::getProfile($model->id); ?>
    <?= $form->field($model, 'name')->textInput(['value'=> isset($name->name) ? $name->name : null]) ?>

    <?= $form->field($model, 'role')->dropDownList(User::$typeUser) ?>

    <?=  $form->field($model, 'status' )->dropDownList([
            User::STATUS_BLOCKED => 'Заблокирован',
            User::STATUS_ACTIVE => 'Активен',
            User::STATUS_WAIT => 'Ожидает подтверждения',
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
