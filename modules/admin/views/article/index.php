<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\Article;
use yii\helpers\Url;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создание новой новости', ['create'], ['class' => 'btn btn-success']) ?>
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
            'url',
            /*[
                'attribute' => 'created',
                'value' => 'created',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],*/
            'status'=>[
                 'class'=>DataColumn::className(),
                 'attribute'=>'status',
                 'filter' => Html::activeDropDownList(
                     $searchModel,
                     'status',
                     Article::$status,
                     ['class' => 'form-control']
                 ),
                 'value'=>function($dataProvider){
                     return Article::$status[$dataProvider->status];
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
