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
use app\models\Subscribes;
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


//if(isset($_GET["subscribe_email"])){
//    header('Location: '.Url::to('/'));
//    exit;
//}
AppAsset::register($this);
?>
<?php $this->beginPage(); ?>



<!doctype html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,400italic,500italic,300italic'
          rel='stylesheet' type='text/css'>
    <title><?= Html::encode($this->title) ?></title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <?php $this->head() ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-66281757-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body <?php
if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id
    == 'news' && isset($_GET['url'])
) {
    echo 'class="bg-news"';
}
if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id
    == 'index'
) {
    echo 'class="h100"';
}
?>>

<?php
if (Yii::$app->user->isGuest and empty($_SESSION['flag'])) {
    $_SESSION['flag'] = true;
    ?>

    <div class="load_video">

        <div class="load_video__wrap">

            <div class="load_video__logo">
                <a href="#"><img src="/web/images/logo.png" alt="#"></a>
            </div>
            <!--.load_video__logo-->

            <div class="load_video__skip" onclick="ga('send', 'event', 'Propusk', 'Click');">Пропустити відео</div>

        </div>
        <!--.load_video__wrap-->

        <video poster="images/bg-main.jpg" preload="none" autoplay id="load_video">
            <source src="/web/video/intro.mp4" type="video/mp4">
            <source src="/web/video/intro.webm" type="video/webm">
            <source src="/web/video/intro.ogv" type="video/ogg">
        </video>

    </div><!--.load_video-->
<?php } ?>


<div class="bg_video">
    <video poster="/web/images/bg-main.jpg" preload="none" loop autoplay muted id="bg_video">
        <source src="/web/video/back.mp4" type="video/mp4">
        <source src="/web/video/back.webm" type="video/webm">
        <source src="/web/video/back.ogv" type="video/ogg">
    </video>
</div>
<!--.bg_video-->

<?php $this->beginBody() ?>
<?php Pjax::begin(['id' => 'body-pjax', 'options' => ['class' => 'container']]); ?>

<div class="top">

    <div class="top__logo">
        <a href="/"><img src="<?= Url::to('/web/images/logo.png'); ?>" alt="#"></a>
    </div>
    <!--.top__logo-->


    <?php
    if (Yii::$app->user->isGuest) {
        ?>
        <div class="top__social">
            <?php $seo = Seo::find()->where(['id' => 1])->one(); ?>
            <ul>
                <li class="fb" onclick="ga('send', 'event', 'Sharefb', 'Click');"><a href="javascript:void(0);"
                                                                                     onclick="Share.facebook('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>'); alert();">>Facebook</a>
                </li>
                <li class="vk" onclick="ga('send', 'event', 'Sharevk', 'Click');"><a href="javascript:void(0);"
                                                                                     onclick="Share.vkontakte('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">ВКонтакте</a>
                </li>
                <li class="ok" onclick="ga('send', 'event', 'Shareok', 'Click');"><a href="javascript:void(0);"
                                                                                     onclick="Share.odnoklassniki('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $seo->title; ?>')">>Одноклассники</a>
                </li>
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
                <li><?php echo Html::a('Результати', Url::to(['site/result'])); ?></li>
            <?php } ?>
            <?php if (!Yii::$app->user->identity) { ?>
                <li><?php echo Html::a('Опитування', Url::to('/')); ?></li>
            <?php } ?>
            <li><?php echo Html::a('Новини', Url::to(['site/news'])); ?></li>
            <li><?php echo Html::a('Про проект', Url::to(['site/about'])); ?></li>

        </ul>
    </div>
    <!--.top__menu-->

</div>
<!--.top-->
<script>
    <?php echo file_get_contents(Yii::getAlias('@webroot/web/js/design.js')); ?>
</script>
<div class="col-lg-12">
    <?php if (Yii::$app->session->hasFlash('consol_v_error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= Yii::$app->session->getFlash('consol_v_error') ?>
        </div>
    <?php endif; ?>
</div>
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




<?php Pjax::end(); ?>

<div class="footer cf">

    <div class="footer__wrap">

        <?php Pjax::begin(['id' => 'subscribe-form-pjax']); ?>
        <div class="footer__subscribe">
            <form id="subscribes" method="get" data-pjax="1">
                <div class="footer__subscribe-in">
                    <input type="email" name="subscribe_email" placeholder="Введіть Ваш E-mail">
                    <input type="submit" value="">
                </div>
            </form>
            <?php if (Yii::$app->session->hasFlash('subscribe_success')): ?>
                <p><?= Yii::$app->session->getFlash('subscribe_success') ?></p>
            <?php endif; ?>
            <?php if (Yii::$app->session->hasFlash('subscribe_error')): ?>
                <p><?php echo print_r(Yii::$app->session->getFlash('subscribe_error'), 1); ?></p>
            <?php endif; ?>
            <?php if (!Yii::$app->session->hasFlash('subscribe_success') and
                !Yii::$app->session->hasFlash('subscribe_error')):
                ?>
                <p>Слідкуйте за нашими новинами у своєму e-mail</p>
            <?php endif; ?>
        </div>
        <?php Pjax::end(); ?>
        <!--.footer__subscribe-->

        <div class="footer__links">
            <ul>
                <li><a href="javascript:void(0);" class="footer__contacts">Контакти</a></li>
                <li><a href="javascript:void(0);" class="footer__conditions">Умови використання</a></li>
                <li><a href="javascript:void(0);" class="footer__politics">Правила конфіденційності</a></li>
            </ul>
        </div>
        <!--.footer__links-->

        <div class="cf"></div>

        <div class="footer__txt">
            <p>© 2015, «сhomu.net». Всі права захищені. Будь-яке копiювання, публiкацiя, передрук чи наступне поширення
                інформації дозволяється тільки при прямому, відкритому для пошукових систем, гіперпосиланні у першому
                абзаці на конкретну новину чи матеріал.</p>
        </div>

    </div>
    <!--.footer__wrap-->

</div>
<!--.footer-->
<div class="popup_holder" style="display: none;">
    <div class="popup_wrap">

        <div class="popup__in">

            <div class="popup popup_auth" style="display: none;">

                <h3>Авторизуватися:</h3>

                <?php echo \nodge\eauth\Widget::widget(array('action' => 'site/social-login')); ?>
                <!--                <ul>-->
                <!--                    <li class="fb"><a href="#">Facebook</a></li>-->
                <!--                    <li class="ok"><a href="#">Одноклассники</a></li>-->
                <!--                    <li class="vk"><a href="#">ВКонтакте</a></li>-->
                <!--                </ul>-->

                <span class="popup-close" onclick="auth_close();
                        return false;">Закрити</span>
            </div>
            <!--.popup_auth-->

            <div class="popup popup_police" style="display: none;">

                <div class="popup_police__in">

                    <h3>Політика конфіденційності</h3>

                    <div class="scroller">

                        <p>1. Сайт сhomu.net використовує стандартні технології для збору технічної інформації про вас як відвідувача і може отримувати відомості про вашу IP-адресу, назву вашого браузера та ін. Відвідуючи сайт сhomu.net, ви даєте згоду на збір і використання цієї інформації сайтом сhomu.net. Дана інформація зберігається у вигляді логів веб-сервера і сервера статистики і використовується для аналізу аудиторії сайту сhomu.net.</p>

                        <p>2. Особисту інформацію (ім'я, адреса, телефон) сhomu.net не збирає і не використовує.</p>

                        <p>3. Відвідувач може налаштувати свій браузер так, щоб він повідомляв про тимчасові файли cookies або автоматично відхиляв їх. Це обмежить збір неособистих даних. Якщо відвідувач відхиляє тимчасові файли сайту сhomu.net або відмовляється від використання таких тимчасових файлів, він може продовжувати відвідувати сайт сhomu.net, але деякі можливості сайту будуть недоступними.
                        </p>

                        <p>4. Сайт сhomu.net залишає за собою право у будь-який час змінювати, модифікувати або оновлювати Правила Конфіденційності сайту сhomu.net, і ви погоджуєтесь із такими змінами та/або оновленнями.</p>

                    </div>

                </div>
                <!--.popup_police__in-->

                <span class="popup-close">Закрити</span>
            </div>
            <!--.popup_police-->


            <div class="popup popup_terms" style="display: none;">

                <div class="popup_terms__in">

                    <h3>Умови використання</h3>

                    <div class="scroller">

                        <p>1. Ці правила поширюються на всі сторінки сайту сhomu.net.</p>

                        <p>2. Всі виключні майнові і немайнові авторські права та інформація, що розміщується на сайті chomu.net належать ГО «ВО Успішна країна» та авторам публікацій, якщо в тексті не вказано інше. Під інформацією розуміються всі матеріали, що розміщуються на сайті: статті, новини, інтерв'ю, фото, відео і т.п.</p>

                        <p>3. Інтернет-виданням дозволяється використовувати інформацію, розміщену на сайті сhomu.net, тільки за умови посилання і згадки першоджерела у першому абзаці.<br>
                            Для друкованих видань передрук матеріалів сайту сhomu.net дозволяється при згадці сайту сhomu.net.<br>
                            У теле- і радіосюжетах дозволяється використання інформації, розміщеної на сайті сhomu.net, за умови усного посилання на першоджерело.<br>
                            Під використанням інформації мається на увазі будь-яке відтворення, републікування, поширення, переробка, переклад наповнення сайту, включення його частин у інші твори та інші способи, передбачені Законом України «Про авторське право і суміжні права».</p>

                        <p>4. Забороняється будь-яке комерційне використання інформації, відтворення текстів або їх фрагментів з метою комерційної реалізації права доступу до цієї інформації.</p>

                        <p>5. У разі порушення будь-якого пункту цих правил, представники ГО «ВО Успішна країна» залишають за собою право захищати свої права та інтереси шляхом подачі скарг до правоохоронних органів та позовних заяв до судових органів.</p>

                    </div>

                </div>
                <!--.popup_terms__in-->

                <span class="popup-close">Закрити</span>
            </div>
            <!--.popup_police-->


            <div class="popup popup_contacts" style="display: none;">

                <div class="popup_contacts__in cf">

                    <div class="popup_contacts__left">
                        <h3>Контакти</h3>

                        <p><b>e-mail:</b> <a href="#">kraina@uspishna.org</a><br>
                            <b>Для ЗМІ:</b> <a href="#">media@uspishna.org</a></p>
                    </div>

                    <div class="popup_contacts__right">
                        <h3>Центральний офіс</h3>

                        <p><b>Адреса:</b> м. Київ, вул. Жилянська, буд. 110<br></p>
                    </div>

                </div>
                <!--.popup_contacts__in-->

                <span class="popup-close">Закрити</span>
            </div>
            <!--.popup_contacts-->

        </div>
        <!--.popup__in-->

        <div class="popup_layer"></div>

    </div>
    <!--.popup_wrap-->
</div>
<!--.popup_holder-->

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>


<style>

    .animate {
        -webkit-animation: fadein 1s; /* Safari, Chrome and Opera > 12.1 */
        -moz-animation: fadein 1s; /* Firefox < 16 */
        -ms-animation: fadein 1s; /* Internet Explorer */
        -o-animation: fadein 1s; /* Opera < 12.1 */
        animation: fadein 1s;
    }

    @keyframes fadein {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Firefox < 16 */
    @-moz-keyframes fadein {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Safari, Chrome and Opera > 12.1 */
    @-webkit-keyframes fadein {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Internet Explorer */
    @-ms-keyframes fadein {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Opera < 12.1 */
    @-o-keyframes fadein {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>