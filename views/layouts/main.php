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

<?php
function subscribes()
{
    $email = (\Yii::$app->request->get('subscribe_email'));
    $confirm = (\Yii::$app->request->get('confirm'));
    if (isset($email)) {
        //$email = $_GET["subscribe_email"];

        $key = md5(microtime() + time() + 1235648);

        $subscribes = new Subscribes();
        $subscribes->email = $email;
        $subscribes->key = $key;
        $subscribes->status = 1;
        if ($subscribes->save()) {
            var_dump("ok");
            $link = $_SERVER['SERVER_NAME'] . '/?confirm=' . $key;

            $message = 'hello your link <a href="http://' . $link . '">' . $link . '</a>';

            Yii::$app->mailer->compose()
                ->setFrom('viktor85a@gmail.com')
                ->setTo($email)
                ->setSubject('Confirmation subscribes')
                ->setHtmlBody($message)
                ->send();
        } else {

            var_dump($subscribes->errors);
        }
    };

    if (isset($confirm)) {
        $model = Subscribes::findOne(['key' => $confirm]);
        $model->status = 2;
        $model->save();
    }
}

subscribes();
?>


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

            <div class="load_video__skip">пропустити відео</div>

        </div>
        <!--.load_video__wrap-->

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
                <li class="fb"><a href="javascript:void(0);"
                                  onclick="Share.facebook('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">>Facebook</a>
                </li>
                <li class="vk"><a href="javascript:void(0);"
                                  onclick="Share.vkontakte('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">ВКонтакте</a>
                </li>
                <li class="ok"><a href="javascript:void(0);"
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
                <li><?php echo Html::a('результати', Url::to(['site/result'])); ?></li>
            <?php } ?>
            <?php if (!Yii::$app->user->identity) { ?>
                <li><?php echo Html::a('опитування', Url::to('/')); ?></li>
            <?php } ?>
            <li><?php echo Html::a('новини', Url::to(['site/news'])); ?></li>
            <li><?php echo Html::a('про проект', Url::to(['site/about'])); ?></li>

        </ul>
    </div>
    <!--.top__menu-->

</div>
<!--.top-->
<script>
    <?php echo file_get_contents(Yii::getAlias('@webroot/web/js/design.js')); ?>
</script>

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

        <div class="footer__subscribe">

            <form id="subscribes" method="get">
                <div class="footer__subscribe-in">
                    <input type="text" name="subscribe_email" placeholder="Введіть Ваш E-mail" class="inp-error">

                    <input type="submit" value="">
                </div>
            </form>

            <p>Слідкуйте за нашими новинами у своєму e-mail</p>
        </div>
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
            <p>© 2015, «Chomu.net». Всі права захищені. Будь-яке копiювання, публiкацiя, передрук чи наступне поширення
                інформації дозволяється<br> тільки при прямому, відкритому для пошукових систем, гіперпосиланні в
                першому абзаці на конкретну новину чи матеріал</p>
        </div>

    </div>
    <!--.footer__wrap-->

</div>
<!--.footer-->
<div class="popup_holder" style="display: none;">
    <div class="popup_wrap">

        <div class="popup__in">

            <div class="popup popup_auth" style="display: none;">

                <h3>Авторизуйтесь<br> за допомогою:</h3>

                <ul>
                    <li class="fb"><a href="#">Facebook</a></li>
                    <li class="ok"><a href="#">Одноклассники</a></li>
                    <li class="vk"><a href="#">ВКонтакте</a></li>
                </ul>

                <span class="popup-close">Закрыть</span>
            </div>
            <!--.popup_auth-->

            <div class="popup popup_police" style="display: none;">

                <div class="popup_police__in">

                    <h3>Політика конфіденційності</h3>

                    <div class="scroller">

                        <p>Сайт Chomu.net використовує стандартні технології для збору технічної інформації про вас як
                            відвідувача і може отримувати відомості про ваш IP-адресу, назву вашого браузера і т. д.
                            Відвідуючи сайт Chomu.net, ви даєте згоду на збір і використання цієї інформації сайтом
                            Chomu .net. Дана інформація зберігається у вигляді логів веб-сервера і сервера статистики і
                            використовується для аналізу аудиторії сайту Chomu.net. Особисту інформацію (ім'я, адреса,
                            телефон) Chomu.net не збирає і не використовує.</p>

                        <p>Ви можете налаштувати ваш браузер так, щоб він повідомляв вас або автоматично відхиляв
                            тимчасові файли cookies, і це обмежить збір неособистих даних. Якщо ви відхиляєте тимчасові
                            файли сайту Chomu.net або відмовляєтеся від використання таких тимчасових файлів, ви можете
                            продовжувати відвідувати сайт Chomu.net, але деякі його можливості будуть для вас
                            недоступні.</p>

                        <p>Модифікація Політика конфіденційності: Chomu.net залишає за собою право в будь-який час
                            змінювати, модифікувати або оновлювати Політику Конфіденційності сайту Chomu.net, і ви
                            погоджуєтеся з такими змінами та / або оновленнями.
                        </p>

                    </div>

                </div>
                <!--.popup_police__in-->

                <span class="popup-close">Закрыть</span>
            </div>
            <!--.popup_police-->


            <div class="popup popup_terms" style="display: none;">

                <div class="popup_terms__in">

                    <h3>Умови використання</h3>

                    <div class="scroller">

                        <p>1. Ці правила поширюються на сайт Chomu.net.</p>

                        <p>2. Всі виключні майнові і немайнові авторські права на інформацію, що розміщується на сайті
                            Chomu.net належать ГО «ВО Успішна країна» та авторам публікацій, якщо в тексті не вказується
                            інше. Під інформацією розуміються всі матеріали, що розміщуються на сайті - статті, новини,
                            інтерв'ю, фото, відео і т. П.</p>

                        <p>3. Інтернет-виданням дозволяється використовувати інформацію, розміщену на сайті Chomu.net,
                            тільки за умови посилання і згадки першоджерела у першому абзаці. Для друкованих видань
                            передрук матеріалів сайту Chomu.net дозволяється при згадці сайту Chomu.net. У теле- і
                            радіосюжетах дозволяється використовувати інформацію, розміщену на сайті Chomu.net, за умови
                            усного посилання на першоджерело. Під використанням інформації мається на увазі будь-яке
                            відтворення, републікування, поширення, переробка, переклад, включення його частин у інші
                            твори й інші способи, передбачені Законом України «Про авторське право і суміжні права».</p>

                        <p>4. Забороняється будь-яке комерційне використання інформації, відтворення текстів або їх
                            фрагментів з метою комерційної реалізації права доступу до цієї інформації.</p>

                        <p>5. У разі порушення будь-якого пункту цих правил, представники ГО «ВО Успішна країна»
                            залишають за собою право захищати свої права та інтереси шляхом подачі скарг до
                            правоохоронних органів та позовних заяв до судових органів.</p>

                    </div>

                </div>
                <!--.popup_terms__in-->

                <span class="popup-close">Закрыть</span>
            </div>
            <!--.popup_police-->


            <div class="popup popup_contacts" style="display: none;">

                <div class="popup_contacts__in cf">

                    <div class="popup_contacts__left">
                        <h3>Контакти</h3>

                        <p><b>e-mail:</b> <a href="#">kraina@uspishna.org</a><br>
                            <b>Для ЗМІ:</b> <a href="#">media@uspishna.org</a><br>
                            <b>Тел.</b> громадської пріймальні : <br>
                            +38 098 387 70 15</p>
                    </div>

                    <div class="popup_contacts__right">
                        <h3>Центральний офіс</h3>

                        <p><b>Адреса:</b> м. Київ, вул. Жілянська, буд. 110<br>
                            <b>Тел.:</b> +38 098 387 68 40</p>
                    </div>

                </div>
                <!--.popup_contacts__in-->

                <span class="popup-close">Закрыть</span>
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
