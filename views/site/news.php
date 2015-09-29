<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Story;
use yii\web\View;

$this->title = isset($new) && $new !== null ? $new->title : 'Новини';
?>
<?php if(isset($news) && $news !== null) {?>

    <div class="news_page animate">

        <?php if($news) {?>
            <div class="news__list scroller scroller-desktop cf">
                <?php foreach($news as $v) {?>
                    <a href="http://<?= Yii::$app->request->getServerName(); ?><?= Url::to(['site/news','url'=> isset($v->url) ? $v->url : null ]); ?>" class="news__item">

                        <div class="thumb">
                            <img src="<?=Url::to('/web/upload/article/').$v->photo;?>" alt="#">
                            <div class="layer"></div>
                            <div class="layer2"></div>
                        </div>

                        <div class="info">
                            <div class="date"><?php $time = explode(' ', $v->created); unset($time[1]); $date = explode('-', $time[0]); echo  $date[2].'/'.$date[1]; ?></div>
                            <h4><?php echo $v->title; ?></h4>
                            <p><?php echo $v->pre_content; ?></p>
                        </div>

                    </a><!--.news__item-->
                <?php } ?>
            </div><!--.news__list-->
        <?php } ?>



    </div><!--.news_page-->

<?php } elseif ( isset($new) && $new !== null ) { ?>


    <?php
    $this->registerJs(
        "var url = 'http://".Yii::$app->request->getServerName()."/news/".htmlspecialchars($new->url).".html';

					    $.getJSON('http://vkontakte.ru/share.php?act=count&index=1&url=' + encodeURI(url) + '&callback=?', function(response) {});
						$.getJSON('http://ok.ru/dk?st.cmd=extLike&uid=odklcnt0&ref='+ encodeURI(url) + '&callback=?', function(response) {});
						$.getJSON('https://api.facebook.com/method/links.getStats?urls='+ encodeURI(url) +'&format=json');
					",

        View::POS_READY
    );
    $this->registerJs(
        "Share.count_fb('http://".Yii::$app->request->getServerName()."/news/".htmlspecialchars($new->url).".html',".$new->id.");",
        View::POS_READY
    );
    $this->registerJs(
        "var VK = {
					        Share: {
					            count: function(value, count) {
					                $('.vk-count_' + ".$new->id.").html(count);
					            }
					    }
					};
					var ODKL = {
								updateCount: function(value, count) {
						                $('.odn-count_' + ".$new->id.").html(count);
								    }
								};
                    var FB =    {
                                updateCount: function(value, count) {
						                $('.fb-count_' + ".$new->id.").html(count);
								    }
								}
					",
        View::POS_READY
    );
    ?>

    <div class="news_page">

        <div class="news_single cf">

            <div class="news_single__top" style="background: url(<?=Url::to('/web/upload/article/').$new->images;?>) center center no-repeat">

                <img src="<?=Url::to('/web/upload/article/').$new->images;?>" alt="#">

                <div class="news_single__info">

                    <a href="http://<?= Yii::$app->request->getServerName(); ?><?= Url::to(['site/news','url'=> $arrow['prev']['url'] ]); ?>" class="news_single__prev"><span></span></a>

                    <div class="date"><?php $time = explode(' ', $new->created); unset($time[1]); $date = explode('-', $time[0]); echo  $date[2].'/'.$date[1]; ?></div>
                    <h2><?= $new->h1; ?></h2>

                    <a href="http://<?= Yii::$app->request->getServerName(); ?><?= Url::to(['site/news','url'=> $arrow['next']['url'] ]); ?>" class="news_single__next"><span></span></a>

                </div><!--.news_single__info-->

            </div><!--.news_single__top-->

            <div class="news_single__body">
                <?= $new->content; ?>
                <div class="news_single__social cf">

                    <ul>
                        <li class="fb" onclick="ga('send', 'event', 'Sharefb', 'Click');">
                            <a href="javascript:void(0);" class="icon icon-social icon-fb icon-has-text active" onclick="Share.facebook('http://<?=Yii::$app->request->getServerName();?><?=Url::to(['site/news','url'=> $new->url]);?>','<?= $new->title; ?>','http://<?= Yii::$app->request->getServerName(); ?>/web/upload/article/<?= $new->photo; ?>','<?= $p; ?>')">

                                <span class="icon-inner-text fb-count_<?=$new->id;?>">
                                    0
                                </span>
                            </a>
                        </li>
                        <li class="ok" onclick="ga('send', 'event', 'Sharevk', 'Click');"><a href="javascript:void(0);" class="icon icon-social icon-ok icon-has-text active" onclick="Share.odnoklassniki('http://<?=Yii::$app->request->getServerName();?><?=Url::to(['site/news','url'=> $new->url]);?>','<?= $new->pre_content; ?>')"><span class="icon-inner-text odn-count_<?=$new->id;?>">0</span></a></li>
                        <li class="vk" onclick="ga('send', 'event', 'Shareok', 'Click');"><a href="javascript:void(0);" class="icon icon-social icon-vk icon-has-text active vk like l-vk" onclick="Share.vkontakte('http://<?=Yii::$app->request->getServerName();?><?=Url::to(['site/news','url'=> $new->url]);?>','<?= $new->title; ?>','http://<?= Yii::$app->request->getServerName(); ?>/web/upload/article/<?= $new->photo; ?>','<?= $p; ?>')"><span href="http://<?=Yii::$app->request->getServerName();?><?=Url::to(['site/news','url'=> $new->url]);?>" class="icon-inner-text l-count vk-count_<?=$new->id;?>">0</span></a></li>
                    </ul>
                </div><!--.news_single__social-->



            </div><!--.news_single__body-->

        </div><!--.news_single-->



    </div><!--.news_page-->
<?php } ?>