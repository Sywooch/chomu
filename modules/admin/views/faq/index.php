<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\Faq;
use yii\helpers\Url;


$this->title = 'Faq';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать Faq', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
                'pjax'=>true,
        'export' => [
            'fontAwesome' => true
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
//            'heading' => $heading,
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'title',
            'status'=>[
                 'class'=>DataColumn::className(),
                 'attribute'=>'status',
                 'filter' => Html::activeDropDownList(
                     $searchModel,
                     'status',
                     Faq::$status,
                     ['class' => 'form-control']
                 ),
                 'value'=>function($dataProvider){
                     return Faq::$status[$dataProvider->status];
                 }
            ],
            [   
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}{link}',
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'toolbar' => [
            '{export}',
            '{toggleData}'
        ],
        'containerOptions'=>['style'=>'overflow: auto'],
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    ]); ?>

</div>
