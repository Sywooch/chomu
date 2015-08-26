<?php

use yii\helpers\Url;

$this->title = 'Дякуємо, ваша відповідь зарахована.';
?>

<div class="thanks_page">

    <div class="thanks_page__in">

        <div class="avatar">
            <img src="<?= $profile->thumb_photo; ?>" alt="">
        </div>

        <h2>Дякуємо!<br></h2>
        <p>ваша відповідь зарахована</p>

        <a href="<?= Url::to(['site/result']); ?>" class="btn-result">Переглянути результати</a>

    </div>

</div><!--.thanks_page-->