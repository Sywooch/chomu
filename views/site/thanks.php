<?php

use yii\helpers\Url;

$this->title = 'Дякуємо, ваша відповідь зарахована.';
?>

<div class="thanks_page">

    <div class="thanks_page__in">

        <div class="avatar">
            <img src="images/img-avatar.png" alt="">
        </div>

        <h2>Дякуємо!<br> Валерій Харченкивський,</h2>
        <p>ваша відповідь зарахована</p>

        <a href="<?= Url::to(['site/result']); ?>" class="btn-result">Переглянути результати</a>

    </div>

</div><!--.thanks_page-->