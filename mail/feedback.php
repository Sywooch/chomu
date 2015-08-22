<?php
use yii\helpers\Html;
?>
<h1 style="font:bold 15px/18px Plumb, Helvetica, Arial, sans-serif; color: #ef7842; margin: 0 0 18px;">
Задати питання
</h1>
<p style="margin: 5px 0;">Имя: <?= $feedback->name; ?></p>
<p style="margin: 5px 0;">E-mail: <?= $feedback->email; ?></p>
<p style="margin: 5px 0;">Сообщение: <?= $feedback->message; ?></p>
<p style="margin: 5px 0;">Дата: <?= $feedback->getdata; ?></p>