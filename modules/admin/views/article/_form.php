<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Url;
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'images')->fileInput() ?>

    <div>
        <?php if($model->images != ''){?>
            <img src="<?=Url::to('/web/upload/article/').$model->images;?>">
        <?php } ?>
    </div>


    <?= $form->field($model, 'photo')->fileInput() ?>

    <div>
        <?php if($model->photo != ''){?>
            <img src="<?=Url::to('/web/upload/article/').$model->photo;?>">
        <?php } ?>
    </div>


    <?= $form->field($model, 'pre_content')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'content')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[ 
                                                    'preset' => 'full',
                                                    'inline' => false,]),
    ]);?>


    <?=  $form->field($model, 'status' )->dropDownList([
            '' => '',
            '0' => 'Закрыть',
            '1' => 'Открыть',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
