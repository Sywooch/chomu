<?php
use yii\helpers\Url;
use app\models\User;
use app\models\Vote;

$this->title = 'Про проект';
?>
<div class="about_page">

	<h2>Про проект</h2>

	<div class="txt">
		<?php echo $model->content; ?>
	</div><!--.txt-->

	
	<div class="txt1">
		Соціологічне дослідження шляхом прямого опитування проводиться Громадською організацією<br>
	<b>«Всеукраїнське об’єднання "Успішна країна"».</b>
	</div>

</div><!--.about_page-->