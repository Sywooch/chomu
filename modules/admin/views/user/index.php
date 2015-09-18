<?php
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\grid\DataColumn;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\User;
use app\modules\admin\models\Profile;
use yii\helpers\Url;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?
$gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],

            /*[
                'attribute' => 'name',
                'value' => 'name.name',
            ],
            'username',*/
            [
                'attribute' => 'name',
                'value'     => function ($model) {
                    return $model->getProfile()->one()->name;
                }
            ],
            [
                'attribute' => 'last_name',
                'value'     => function ($model) {
                    return $model->getProfile()->one()->last_name;
                }
            ],
            [
                'attribute' => 'email',
                'value' => 'email',
                //'filter' => false,
            ],
            [
                'attribute' => 'social_id',
                'value' => 'social_id',
                //'filter' => false,
            ],
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
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
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}{link}',
            ],
        ];

$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            /*[
                'attribute' => 'name',
                'value' => 'name.name',
            ],
            'username',*/
            [
                'attribute' => 'name',
                'value'     => function ($model) {
                    return $model->getProfile()->one()->name;
                }
            ],
            [
                'attribute' => 'last_name',
                'value'     => function ($model) {
                    return $model->getProfile()->one()->last_name;
                }
            ],
            'email:email',
            'social_id',
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
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
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}{link}',
            ],
        ],
    'target' => ExportMenu::TARGET_BLANK,
    'fontAwesome' => true,
    'pjaxContainerId' => 'kv-pjax-container',
    'dropdownOptions' => [
        'label' => 'Все',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Экспорт всех данных</li>',
        ],
    ],
    'exportConfig' => [
    ExportMenu::FORMAT_PDF => false,
],
]); 

?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => false,
        'columns' => $gridColumns,
        'pjax'=>true,
        'export' => /*[
            'fontAwesome' => true
        ],*/ false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
//            'heading' => $heading,
        ],
        'responsive'=>true,
        'hover'=>true,
        'toolbar' => [
            $fullExportMenu,
            //'{export}',
            '{toggleData}'
        ],
        'containerOptions'=>['style'=>'overflow: auto'],
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    ]); ?>

</div>
