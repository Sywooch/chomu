<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    	<table width="100%" border="0" cellpadding="0" cellspacing="0" style=" margin: 0; background: #fff; font:13px/18px Plumb, Helvetica, Arial, sans-serif; color: #282828; text-align: left;">
		<tr height="1" valign="top">
			<td style="padding: 0;">
				<table width="410" border="0" cellpadding="0" cellspacing="0" style=" margin: 0 auto; font:13px/18px Plumb, elvetica, Arial, sans-serif; color: #212121; text-align: left;">
					<tr height="1" valign="top">
						<td width="410" style="padding: 40px 0 48px;">
							<a href="http://<?= Yii::$app->request->getServerName(); ?>" style="display: block; width: 115px; margin: 0 auto;"><img src="http://<?= Yii::$app->request->getServerName(); ?>/web/img/logo_champ.png" alt="" width="115" height="101" style="display: block;" /></a>
						</td>
					</tr>
					<tr height="1" valign="top">
						<td width="410" style="padding: 0 0 105px;">
    					<?= $content ?>
    					</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr height="1" valign="top">
			<td style="padding: 20px 0 30px; background: #ef7841;">
				<a href="http://<?= Yii::$app->request->getServerName(); ?>" style="display: block; width: 50px; margin: 0 auto;"><img src="http://<?= Yii::$app->request->getServerName(); ?>/web/img/logo_email.png" alt="" width="50" height="29" style="display: block;" /></a>
			</td>
		</tr>
	</table>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
