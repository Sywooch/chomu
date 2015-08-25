<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Subscribes */

$this->title = Yii::t('app', 'Create Subscribes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subscribes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscribes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
