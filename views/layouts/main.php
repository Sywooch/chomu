<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\bootstrap\Alert;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use app\controllers\ProfileController;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use app\models\Seo;
use app\models\TokenForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Session;
use yii\web\Response;
use app\components\AlertWidget;
use nodge\eauth\Widget;
use app\models\PasswordResetRequestForm;
use yii\widgets\Pjax;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,400italic,500italic,300italic' rel='stylesheet' type='text/css'>
        <title><?= Html::encode($this->title) ?></title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <?php $this->head() ?>
    </head>

    <body <?php
    if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id
        == 'news' && isset($_GET['url'])) {
        echo 'class="bg-news"';
    } if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id
        == 'index') {
        echo 'class="h100"';
    }
    ?>>

    <?php
    if (Yii::$app->user->isGuest) {?>
        <div class="load_video">

            <div class="load_video__wrap">

                <div class="load_video__logo">
                    <a href="#"><img src="/web/images/logo.png" alt="#"></a>
                </div><!--.load_video__logo-->

                <div class="load_video__skip">пропустити відео</div>

            </div><!--.load_video__wrap-->

            <video poster="images/bg-main.jpg" preload="none" autoplay id="load_video">
                <source src="/web/video/Office-1.mp4" type="video/mp4">
                <source src="/web/video/Office-1.webm" type="video/webm">
                <source src="/web/video/Office-1.webm" type="video/ogg">
            </video>

        </div><!--.load_video-->
    <?php } ?>


    <div class="bg_video">
            <video poster="/web/images/bg-main.jpg" preload="none" loop autoplay muted id="bg_video">
                <source src="/web/video/Office-1.mp4" type="video/mp4">
                <source src="/web/video/Office-1.webm" type="video/webm">
                <source src="/web/video/Office-1.webm" type="video/ogg">
            </video>
        </div><!--.bg_video-->

        <?php $this->beginBody() ?>
        <?php Pjax::begin(['id' => 'body-pjax', 'options' => ['class' => 'container']]); ?>

        <div class="top">

            <div class="top__logo">
                <a href="/"><img src="<?= Url::to('/web/images/logo.png'); ?>" alt="#"></a>
            </div><!--.top__logo-->


            <?php
            if (Yii::$app->user->isGuest) {
                ?>
                <div class="top__social">
                    <?php $seo = Seo::find()->where(['id' => 1])->one(); ?>
                    <ul>
                        <li class="fb"><a href="javascript:void(0);" onclick="Share.facebook('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">>Facebook</a></li>
                        <li class="vk"><a href="javascript:void(0);" onclick="Share.vkontakte('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">ВКонтакте</a></li>
                        <li class="ok"><a href="javascript:void(0);" onclick="Share.odnoklassniki('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $seo->title; ?>')">>Одноклассники</a></li>
                    </ul>
                </div><!--.top__social-->
            <?php } ?>

            <?php
            if (!Yii::$app->user->isGuest) {
                $profile = Yii::$app->user->identity->getProfile()->one();
                ?>
                <div class="top__usr">
                    <div class="avatar">
                        <img src="<?= $profile->thumb_photo; ?>" alt="">
                    </div>
                    <div class="name"><?= $profile->name ?><br> <?= $profile->last_name ?></div>
                </div>
            <?php } ?>


            <div class="top__menu">
                <ul>
                    <?php if (Yii::$app->user->identity) { ?>
                        <li><?php echo Html::a('результати', Url::to(['site/result'])); ?></li>
                    <?php } ?>
                    <?php if (!Yii::$app->user->identity) { ?>
                        <li><?php echo Html::a('опитування', Url::to('/')); ?></li>
                    <?php } ?>
                    <li><?php echo Html::a('новини', Url::to(['site/news'])); ?></li>
                    <li><?php echo Html::a('про проект', Url::to(['site/about'])); ?></li>

                </ul>
            </div><!--.top__menu-->

        </div><!--.top-->

        <?= $content ?>

        <div class="push"></div>

        <script>
            $(document).ready(function () {
                var url = document.location.pathname;
                var select = $('.top__menu > ul > li');
                urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
                select.each(function () {
                    if (url == $(this).find('a').attr('href')) {
                        $(this).addClass('active');
                    }
                });
            });
        </script>


        <script>
<?php echo file_get_contents(Yii::getAlias('@webroot/web/js/design.js')); ?>
        </script>

        <?php Pjax::end(); ?>

        <div class="footer cf">

            <div class="footer__wrap">

                <div class="footer__subscribe">

                    <form action="#">
                        <div class="footer__subscribe-in">
                            <input type="text" name="#" placeholder="Введіть Ваш E-mail">
                            <input type="submit" value="">
                        </div>
                    </form>

                    <p>Слідкуйте за нашими новинами у своєму e-mail</p>
                </div><!--.footer__subscribe-->

                <div class="footer__links">
                    <ul>
                        <li><a href="#">Контакти</a></li>
                        <li><a href="#">Умови використання</a></li>
                        <li><a href="#">Правила конфіденційності</a></li>
                    </ul>
                </div><!--.footer__links-->

                <div class="cf"></div>

                <div class="footer__txt">
                    <p>© 2015, «Chomu.net». Всі права захищені. Будь-яке копiювання, публiкацiя, передрук чи наступне поширення інформації дозволяється<br> тільки при прямому, відкритому для пошукових систем, гіперпосиланні в першому абзаці на конкретну новину чи матеріал</p>
                </div>

            </div><!--.footer__wrap-->

        </div><!--.footer-->

        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
