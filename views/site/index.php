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

<div class="vam block__hide " >
    <div class="vam__in animate">

        <div class="main_page ">

            <div class="txt1">
                <h2>Чи голосуєш<br>ти на виборах?</h2>
                <p>Проект «Чому?» — всеукраїнське соціологічне дослідження, метою якого є <br> звернути увагу суспільства та влади на мотивацію українців під час голосувань на виборах. <br>Організатор опитування, ГО "ВО Успішна країна”, гарантує повну конфіденційність відповідей.</p>
            </div>

            <div class="main_page__switch">
                <div class="main_page__switch-btn main_page__switch-btnleft main_page__switch-btn--active" onclick="OpenYes();
                        return false;">Так, я голосую</div>
                <div class="main_page__switch-btn main_page__switch-btnright" onclick="OpenNo();
                        return false;">Ні, я не голосую</div>
            </div><!--.main_page__switch-->

        </div><!--.main_page-->

    </div><!--.vam__in-->
<!--.vam-->
</div>
<!-- vote yes start -->

<style>
    .vote_page__list ul li input[type="text"] {
        outline: none;

        display: inline-block;
        width: 500px;
        border: none;

        background-color: transparent;

        font: normal 26px/140% "Roboto", Arial;
        color: #fff;
        vertical-align: middle;

        cursor: pointer;
    }
</style>

        <div class="vote_page vote_yes_this animate" style="display:none;">
<div class="vam"><div class="vam__in">
    <h2>Чому «так»? <br>Назви причину!</h2>

    <form type="POST" action="<?= Url::to(['site/vote']); ?>" id="yes-form">

        <div class="vote_page__list">
            <ul>
                <?php
                foreach ($questionsYes as $key => $value) {
                    echo '<li><input type="radio" name="vote" class="inp-decorate inp-vote" id="' . $value->id . '" checked="" value="' . $value->questions . '"> <label for="' . $value->id . '">' . $value->questions . '</label></li>';
                }
                ?>
                <li class="myvote">
                    <input type="radio" name="vote" class="inp-decorate inp-vote" id="1000001">
                    <label for="vote_page6">
                        <input type="text" id="custom_yes_answer" name="vote" placeholder="Власний варіант відповіді" value="Власний варіант відповіді">
                    </label>
                </li>

            </ul>
        </div><!--.vote_page__list-->

        <input type="submit" value="Відповісти" class="btn-y-bordered" onclick="ga('send', 'event', 'Vidpovisty', 'Click');">

    </form>



</div></div>
</div><!--.vote_page-->
 


<!-- vote yes end -->


<!-- vote no start -->

<div class="vote_page vote_no_this animate" style="display:none;">

    <h2>Чому «ні»? <br/>Назви причину!</h2>

    <form type="POST" action="<?= Url::to(['site/vote']); ?>" id="no-form">

        <div class="vote_page__list">
            <ul>
                <?php
                foreach ($questionsNo as $key => $value) {
                    echo '<li><input type="radio" name="vote" class="inp-decorate inp-vote" id="' . $value->id . '" checked="" value="' . $value->questions . '"> <label for="' . $value->id . '">' . $value->questions . '</label></li>';
                }
                ?>
                <li class="myvote">
                    <input type="radio" name="vote" class="inp-decorate inp-vote" id="1000002">
                    <label for="vote_page6">
                        <input type="text" id="custom_no_answer" name="vote" placeholder="Власний варіант відповіді" value="Власний варіант відповіді">
                    </label>
                </li>
            </ul>
        </div><!--.vote_page__list-->

        <input type="submit" value="Відповісти" class="btn-y-bordered" onclick="ga('send', 'event', 'Vidpovisty', 'Click');">

    </form>



</div><!--.vote_page-->

<!-- vote no end -->

<div class="main_auth main_authnew animate" style="display:none;">

    <h2>Допоможи зробити<br> опитування достовірним </h2>

    <p>Авторизуйся, щоб ми знали, що ти — не "робот"!</p>

    <a href="javascript:void(0);" class="btn-auth" onclick="auth_user();
            return false;">Авторизуватися</a>

    <p>Ми нічого і ніколи не будемо публікувати від твого імені. <br>
        Авторизація потрібна лише для захисту від повторних голосування. <br>
        Авторизуйся щоб побачити загальні результати голосування.</p>


</div><!--.main_auth-->

<div class="popup_holder_ animate" style="display:none;">
    <div class="popup_wrap">

        <div class="popup__in">
            <div class="popup popup_auth">

                <h3>Обери профіль <br/>для авторизації:</h3>

                <?php echo \nodge\eauth\Widget::widget(array('action' => 'site/social-login')); ?>
                <span class="popup-close" onclick="auth_close();
                        return false;">Закрити</span>
            </div><!--.popup_auth-->


        </div>

        <div class="popup_layer"></div>

    </div><!--.popup_wrap-->
</div><!--.popup_holder-->
<?php if(Yii::$app->session->hasFlash('succes')): ?>
<div class="popup_holder_ animate succes" style="display:none;">
    <div class="popup_wrap">

        <div class="popup__in">
            <div class="popup popup_succes">

                <h4><?= Yii::$app->session->getFlash('success');?></h4>
                 <span class="popup-close" onclick="auth_close();
                        return false;">Закрити</span>
            </div><!--.popup_auth-->


        </div>

        <div class="popup_layer"></div>

    </div><!--.popup_wrap-->
</div><!--.popup_holder-->
    <script>
        $('.succes').fadeIn(250);
    </script>
<?php endif; ?>

