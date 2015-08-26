<?php

use yii\helpers\Url;
use app\models\User;
use app\models\Vote;
use app\models\Seo;

$this->title = 'Результати опитування';
?>

<div class="result_page">

    <div class="result_page__in">

        <h2>Результати опитування</h2>

        <div class="result_page__graph">

            <div class="result_page__left">

                <h3>Я голосую</h3>

                <div class="line__progress line__progress-1">
                    <span><?= $result['yes']['percent']; ?></span>
                </div><!--.line__progress-->

                <div class="cf"></div>

                <a href="javascript:void(0);" class="btn-b-bordered" onclick="resultYes();
                        return false;">Детальніше</a>

            </div><!--.result_page__left-->


            <div class="result_page__right">

                <h3>Я не голосую</h3>

                <div class="line__progress line__progress-2">
                    <span><?= $result['no']['percent']; ?></span>
                </div><!--.line__progress-->

                <div class="cf"></div>

                <a href="javascript:void(0);" class="btn-b-bordered" onclick="resultNo();
                        return false;">Детальніше</a>

            </div><!--.result_page__right-->

        </div><!--.result_page__graph-->

        <div class="w_page__bt">
            <h4>Розказати друзям</h4>
            
            <?php $seo = Seo::find()->where(['id' => 1])->one(); ?>
            <ul>
                <li class="fb"><a href="javascript:void(0);" onclick="Share.facebook('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">>Facebook</a></li>
                <li class="vk"><a href="javascript:void(0);" onclick="Share.vkontakte('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">ВКонтакте</a></li>
                <li class="ok"><a href="javascript:void(0);" onclick="Share.odnoklassniki('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $seo->title; ?>')">>Одноклассники</a></li>
            </ul>
        </div><!--.w_page__bt-->

    </div><!--.result_page__in-->

</div><!--.result_page--> 

<div class="vote_result vote_yes" style="display:none;">

    <div class="vote_result__in">

        <div class="vote_result__head cf">
            <h3>Результат “Я голосую”</h3>

            <div class="result"><b><?= $result['yes']['percent']; ?></b><span>%</span></div>

        </div><!--.vote_result__head-->

        <div class="vote_result__list">
            <?php foreach ($questionsYes as $key => $value) { ?>
                <div class="vote_result__item cf">
                    <h4><span><?= $key + 1; ?>.</span><?= $value->questions; ?></h4>

                    <div class="progress">
                        <div class="progress__in" style="width: <?= $result['questions'][$value->id]['percent']; ?>%;"></div>
                        <div class="progress__txt"><span class="countto__number"><?= $result['questions'][$value->id]['percent']; ?></span><span class="prc">%</span></div>
                    </div><!--.progress-->

                    <div class="smile smile<?= $result['questions'][$value->id]['smile']; ?>"></div>

                </div><!--.vote_result__item-->
                <?php
            }
            ?>        

        </div><!--.vote_result__list-->

        <div class="w_page__bt">
            <h4>Розказати друзям</h4>

            <?php $seo = Seo::find()->where(['id' => 1])->one(); ?>
            <ul>
                <li class="fb"><a href="javascript:void(0);" onclick="Share.facebook('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">>Facebook</a></li>
                <li class="vk"><a href="javascript:void(0);" onclick="Share.vkontakte('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">ВКонтакте</a></li>
                <li class="ok"><a href="javascript:void(0);" onclick="Share.odnoklassniki('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $seo->title; ?>')">>Одноклассники</a></li>
            </ul>

            <a href="javascript:void(0);" class="btn-b-bordered"  onclick="back();
                    return false;">Назад</a>

        </div><!--.w_page__bt-->

    </div><!--.vote_result__in-->

</div><!--.vote_result-->

<div class="vote_result vote_no" style="display:none;">

    <div class="vote_result__in">

        <div class="vote_result__head cf">
            <h3>Результат “Я не голосую”</h3>

            <div class="result"><b><?= $result['no']['percent']; ?></b><span>%</span></div>

        </div><!--.vote_result__head-->

        <div class="vote_result__list">
            <?php foreach ($questionsNo as $key => $value) { ?>
                <div class="vote_result__item cf">

                    <h4><span><?= $key + 1; ?>.</span> <?= $value->questions; ?></h4>

                    <div class="progress">
                        <div class="progress__in" style="width: <?= $result['questions'][$value->id]['percent']; ?>%;"></div>
                        <div class="progress__txt"><span class="countto__number"><?= $result['questions'][$value->id]['percent']; ?></span><span class="prc">%</span></div>
                    </div><!--.progress-->

                    <div class="smile smile<?= $result['questions'][$value->id]['smile']; ?>"></div>

                </div><!--.vote_result__item-->
                <?php
            }
            ?>
        </div><!--.vote_result__list-->

        <div class="w_page__bt">
            <h4>Розказати друзям</h4>
            
            <?php $seo = Seo::find()->where(['id' => 1])->one(); ?>
            <ul>
                <li class="fb"><a href="javascript:void(0);" onclick="Share.facebook('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">>Facebook</a></li>
                <li class="vk"><a href="javascript:void(0);" onclick="Share.vkontakte('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $this->title; ?>', '<?= 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images; ?>', '<?= $seo->title; ?>')">ВКонтакте</a></li>
                <li class="ok"><a href="javascript:void(0);" onclick="Share.odnoklassniki('<?= 'http://' . Yii::$app->request->getServerName(); ?>', '<?= $seo->title; ?>')">>Одноклассники</a></li>
            </ul>

            <a href="javascript:void(0);" class="btn-b-bordered"  onclick="back();
                    return false;">Назад</a>

        </div><!--.w_page__bt-->

    </div><!--.vote_result__in-->

</div><!--.vote_result-->