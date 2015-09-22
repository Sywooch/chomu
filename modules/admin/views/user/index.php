<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\User;
use app\modules\admin\models\Profile;
use yii\helpers\Url;

$this->title                   = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export all', ['export', 'format' => 'csv'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'pjax'         => true,
        'export'       => [
            'fontAwesome' => true
        ],
        'panel'        => [
            'type' => GridView::TYPE_PRIMARY,
//            'heading' => $heading,
        ],
        'columns'      => [
            ['class' => 'kartik\grid\SerialColumn'],
            //'username',
            [
                'attribute' => 'name',
                'value'     => function ($model) {
                    return $model->getProfile()->one()->name;
                },
                'filter' => false,
            ],
            [
                'attribute' => 'last_name',
                'value'     => function ($model) {
                    return $model->getProfile()->one()->last_name;
                },
                'filter'       => false,
            ],
            'email:email',
            'social_id',
            [
                'attribute' => 'created_at',
                'value'     => 'created_at',
                'format'    => ['date', 'php:Y-m-d H:i:s'],
            /* 'filter' => DatePicker::widget([
              'model' => $searchModel,
              'attribute' => 'created_at',
              'template' => '{addon}{input}',
              'clientOptions' => [
              'autoclose' => true,
              'format' => 'yyyy-m-d'
              ]
              ]), */
            ],
            [
                'class'    => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}{link}',
            ],
        ],
        'responsive'       => true,
        'hover'            => true,
        'toolbar'          => [
            '{export}',
        //'{toggleData}'
        ],
        'containerOptions' => ['style' => 'overflow: auto'],
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    ]);
    ?>

</div>