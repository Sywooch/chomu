<?php
use yii\helpers\Html;
 
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->email_confirm_token]);
?>
<h1 style="font:bold 15px/18px Plumb, Helvetica, Arial, sans-serif; color: #ef7842; margin: 0 0 18px;">
Здравствуйте, <?= Html::encode($name) ?>!
</h1>
<p style="margin: 5px 0;">Это ваш пароль: <b><?= Html::encode($password) ?></b></p>
<p style="margin: 5px 0;">Если Вы не регистрировались в нашем сайте, то просто удалите это письмо.</p>