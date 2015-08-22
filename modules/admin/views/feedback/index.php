<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\Feedback;
use yii\helpers\Url;


$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <h1><?= Html::encode($this->title) ?></h1>

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

            'name',
            'email:email',
            'message:ntext',
            [
                'attribute' => 'getdata',
                'value' => 'getdata',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
                /*'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-m-d'
                            ]
                    ]),*/
            ],
            'status'=>[
                 'class'=>DataColumn::className(),
                 'attribute'=>'status',
                 'filter' => Html::activeDropDownList(
                     $searchModel,
                     'status',
                     Feedback::$active,
                     ['class' => 'form-control']
                 ),
                 'value'=>function($dataProvider){
                     return Feedback::$active[$dataProvider->status];
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
