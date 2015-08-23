<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\VoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Votes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Vote'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
                'pjax'=>true,
        'export'           => [
            'fontAwesome' => true
        ],
        'panel'            => [
            'type' => GridView::TYPE_PRIMARY,
//            'heading' => $heading,
        ],
        'responsive'       => true,
        'hover'            => true,
        'toolbar'          => [
            '{export}',
            '{toggleData}'
        ],
        'containerOptions' => ['style' => 'overflow: auto'],
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'questions_id',
            'vote',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
