<?php

use app\models\Vote;
use app\models\Yes;
use app\models\No;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\bootstrap\Alert;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use app\models\Seo;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Session;
use yii\web\Response;
use app\components\AlertWidget;
use nodge\eauth\Widget;
use app\models\PasswordResetRequestForm;

$this->title = Seo::find()->where(['id' => 1])->one()->title;
?>

<div class="vam block__hide" style="margin-top: 100px;">
    <div class="vam__in">

        <div class="main_page">

            <div class="txt1">
                <h2>Чи голосуєш ти?</h2>
                <p>Проект є громадським та не прив'язаним до політики.<br> Опитування носить інформаційний характер.</p>
            </div>

            <div class="main_page__switch">
                <div class="main_page__switch-btn main_page__switch-btnleft main_page__switch-btn--active" onclick="OpenYes();
                        return false;">Чому я голосую</div>
                <div class="main_page__switch-btn main_page__switch-btnright" onclick="OpenNo();
                        return false;">Чому я <u>не</u> голосую</div>
            </div><!--.main_page__switch-->

        </div><!--.main_page-->

    </div><!--.vam__in-->
</div><!--.vam-->

<!-- vote yes start -->

<div class="vote_page vote_yes_this" style="display:none;">

    <h2>Скажи чесно! <br>чому так?</h2>

    <form type="POST" action="<?= Url::to(['site/vote']); ?>" id="yes-form">

        <div class="vote_page__list">
            <ul>
                <?php
                foreach ($questionsYes as $key => $value) {
                    echo '<li><input type="radio" name="vote" class="inp-decorate inp-vote" id="' . $value->id . '" checked="" value="' . $value->questions . '"> <label for="' . $value->id . '">' . $value->questions . '</label></li>';
                }
                ?>

            </ul>
        </div><!--.vote_page__list-->

        <input type="submit" value="Відповісти" class="btn-y-bordered">

    </form>


    <div class="txt1">
        Соціологічне дослідження шляхом прямого опитування проводиться Громадською організацією<br>
        <b>«Всеукраїнське об’єднання "Успішна країна"».</b>
    </div>

</div><!--.vote_page-->

<!-- vote yes end -->


<!-- vote no start -->

<div class="vote_page vote_no_this" style="display:none;">

    <h2>Скажи чесно! <br>чому ні?</h2>

    <form type="POST" action="<?= Url::to(['site/vote']); ?>" id="no-form">

        <div class="vote_page__list">
            <ul>
                <?php
                foreach ($questionsNo as $key => $value) {
                    echo '<li><input type="radio" name="vote" class="inp-decorate inp-vote" id="' . $value->id . '" checked="" value="' . $value->questions . '"> <label for="' . $value->id . '">' . $value->questions . '</label></li>';
                }
                ?>
            </ul>
        </div><!--.vote_page__list-->

        <input type="submit" value="Відповісти" class="btn-y-bordered">

    </form>


    <div class="txt1">
        Соціологічне дослідження шляхом прямого опитування проводиться Громадською організацією<br>
        <b>«Всеукраїнське об’єднання "Успішна країна"».</b>
    </div>

</div><!--.vote_page-->

<!-- vote no end -->

<div class="main_auth" style="display:none;">

    <h2>Твій голос буде врахований, <br>як тільки ти авторизуєтесь.</h2>

    <a href="javascript:void(0);" class="btn-auth" onclick="auth_user();
            return false;">Авторизуватись</a>

    <p>Ми нічого і ніколи не будемо публікувати від твого імені.<br> Авторизація потрібна лише для захисту від повторних голосування.<br> Авторизуйся щоб побачити загальні результати голосування.</p>

    <div class="txt1">
        Соціологічне дослідження шляхом прямого опитування проводиться Громадською організацією<br>
        <b>«Всеукраїнське об’єднання "Успішна країна"».</b>
    </div>

</div><!--.main_auth-->

<div class="popup_holder">
    <div class="popup_wrap">

        <div class="popup__in">
            <div class="popup popup_auth">

                <h3>Авторизуйтесь<br> за допомогою:</h3>    

                <?php echo \nodge\eauth\Widget::widget(array('action' => 'site/social-login')); ?>

                <span class="popup-close" onclick="auth_close();
                        return false;">Закрыть</span>
            </div><!--.popup_auth-->
        </div>

        <div class="popup_layer"></div>

    </div><!--.popup_wrap-->
</div><!--.popup_holder-->