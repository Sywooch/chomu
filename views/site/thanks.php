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
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Session;
use yii\web\Response;
use app\components\AlertWidget;
use nodge\eauth\Widget;
use app\models\PasswordResetRequestForm;


$this->title = 'Дякуємо!, ваша відповідь зарахована.';
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

	
	<div class="txt1">
		Соціологічне дослідження шляхом прямого опитування проводиться Громадською організацією<br>
	<b>«Всеукраїнське об’єднання "Успішна країна"».</b>
	</div>

</div><!--.thanks_page-->