<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\Feedback;
use yii\helpers\Url;


$this->title = 'Контент сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">

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
            [   
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {link}',
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
