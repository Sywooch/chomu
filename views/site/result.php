<?php

use yii\helpers\Url;
use app\models\User;
use app\models\Vote;

$this->title = 'Результати опитування';
?>

<div class="result_page">

    <div class="result_page__in">

        <h2>Результат опитування</h2>

        <div class="result_page__graph">

            <div class="result_page__left">

                <h3>Так</h3>

                <div class="line__progress line__progress-1">
                    <span></span>
                </div><!--.line__progress-->

                <div class="cf"></div>

                <a href="javascript:void(0);" class="btn-b-bordered" onclick="resultYes(); return false;">Подробиці</a>

            </div><!--.result_page__left-->


            <div class="result_page__right">

                <h3>Ні</h3>

                <div class="line__progress line__progress-2">
                    <span></span>
                </div><!--.line__progress-->

                <div class="cf"></div>

                <a href="javascript:void(0);" class="btn-b-bordered" onclick="resultNo(); return false;">Подробиці</a>

            </div><!--.result_page__right-->

        </div><!--.result_page__graph-->

        <div class="w_page__bt">
            <h4>Поділитись з друзями</h4>
            <ul>
                <li class="fb"><a href="#">Facebook</a></li>
                <li class="ok"><a href="#">Одноклассники</a></li>
                <li class="vk"><a href="#">ВКонтакте</a></li>
            </ul>
        </div><!--.w_page__bt-->

    </div><!--.result_page__in-->

</div><!--.result_page-->

<div class="vote_result vote_yes" style="display:none;">

	<div class="vote_result__in">

		<div class="vote_result__head cf">
			<h3>Результат опитування</h3>

			<h4>Так</h4>
			<div class="result"><b>37</b>%</div>

		</div><!--.vote_result__head-->

		<div class="vote_result__list">

			<div class="vote_result__item cf">

				<h4><span>1.</span> Мені не байдуже моє майбутнє</h4>

				<div class="progress">
					<div class="progress__in" style="width: 36%;"></div>
					<div class="progress__txt"><span class="countto__number">36</span>%</div>
				</div><!--.progress-->

				<div class="smile smile1"></div>

			</div><!--.vote_result__item-->

			<div class="vote_result__item cf">

				<h4><span>2.</span> Тому що маю голос</h4>

				<div class="progress">
					<div class="progress__in" style="width: 3%;"></div>
					<div class="progress__txt"><span class="countto__number">3</span>%</div>
				</div><!--.progress-->

				<div class="smile smile2"></div>

			</div><!--.vote_result__item-->

			<div class="vote_result__item cf">

				<h4><span>3.</span> Вiрю, що мiй голос може щось змiнити</h4>

				<div class="progress">
					<div class="progress__in" style="width: 17%;"></div>
					<div class="progress__txt"><span class="countto__number">17</span>%</div>
				</div><!--.progress-->

				<div class="smile smile3"></div>

			</div><!--.vote_result__item-->

			<div class="vote_result__item cf">

				<h4><span>4.</span> Це мій обов’язок</h4>

				<div class="progress">
					<div class="progress__in" style="width: 2%;"></div>
					<div class="progress__txt"><span class="countto__number">2</span>%</div>
				</div><!--.progress-->

				<div class="smile smile4"></div>

			</div><!--.vote_result__item-->

			<div class="vote_result__item cf">

				<h4><span>5.</span> Не хочу, щоб від мого імені віддали голос</h4>

				<div class="progress">
					<div class="progress__in" style="width: 100%;"></div>
					<div class="progress__txt"><span class="countto__number">100</span>%</div>
				</div><!--.progress-->

				<div class="smile smile5"></div>

			</div><!--.vote_result__item-->

		</div><!--.vote_result__list-->

		<div class="w_page__bt">
			<h4>Поділитись з друзями</h4>
			<ul>
				<li class="fb"><a href="#">Facebook</a></li>
				<li class="ok"><a href="#">Одноклассники</a></li>
				<li class="vk"><a href="#">ВКонтакте</a></li>
			</ul>

                        <a href="javascript:void(0);" class="btn-b-bordered"  onclick="back(); return false;">Назад</a>

		</div><!--.w_page__bt-->

	</div><!--.vote_result__in-->

</div><!--.vote_result-->

<div class="vote_result vote_no" style="display:none;">

	<div class="vote_result__in">

		<div class="vote_result__head cf">
			<h3>Результат опитування</h3>

			<h4>Ні</h4>
			<div class="result"><b>37</b>%</div>

		</div><!--.vote_result__head-->

		<div class="vote_result__list">

			<div class="vote_result__item cf">

				<h4><span>1.</span> Мені не байдуже моє майбутнє</h4>

				<div class="progress">
					<div class="progress__in" style="width: 36%;"></div>
					<div class="progress__txt"><span class="countto__number">36</span>%</div>
				</div><!--.progress-->

				<div class="smile smile6"></div>

			</div><!--.vote_result__item-->

			<div class="vote_result__item cf">

				<h4><span>2.</span> Тому що маю голос</h4>

				<div class="progress">
					<div class="progress__in" style="width: 3%;"></div>
					<div class="progress__txt"><span class="countto__number">3</span>%</div>
				</div><!--.progress-->

				<div class="smile smile7"></div>

			</div><!--.vote_result__item-->

			<div class="vote_result__item cf">

				<h4><span>3.</span> Вiрю, що мiй голос може щось змiнити</h4>

				<div class="progress">
					<div class="progress__in" style="width: 17%;"></div>
					<div class="progress__txt"><span class="countto__number">17</span>%</div>
				</div><!--.progress-->

				<div class="smile smile8"></div>

			</div><!--.vote_result__item-->

			<div class="vote_result__item cf">

				<h4><span>4.</span> Це мій обов’язок</h4>

				<div class="progress">
					<div class="progress__in" style="width: 2%;"></div>
					<div class="progress__txt"><span class="countto__number">2</span>%</div>
				</div><!--.progress-->

				<div class="smile smile9"></div>

			</div><!--.vote_result__item-->

			<div class="vote_result__item cf">

				<h4><span>5.</span> Не хочу, щоб від мого імені віддали голос</h4>

				<div class="progress">
					<div class="progress__in" style="width: 100%;"></div>
					<div class="progress__txt"><span class="countto__number">100</span>%</div>
				</div><!--.progress-->

				<div class="smile smile10"></div>

			</div><!--.vote_result__item-->

		</div><!--.vote_result__list-->

		<div class="w_page__bt">
			<h4>Поділитись з друзями</h4>
			<ul>
				<li class="fb"><a href="#">Facebook</a></li>
				<li class="ok"><a href="#">Одноклассники</a></li>
				<li class="vk"><a href="#">ВКонтакте</a></li>
			</ul>

			<a href="javascript:void(0);" class="btn-b-bordered"  onclick="back(); return false;">Назад</a>

		</div><!--.w_page__bt-->

	</div><!--.vote_result__in-->

</div><!--.vote_result-->