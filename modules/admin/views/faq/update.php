<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Faq */

$this->title = 'Обновление Faq: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Faq', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="faq-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
