<?php
 
use yii\helpers\Html;
use app\components\AlertWidget;
use app\models\Story;
use app\models\User;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'EVA – Мама року';
?>
                <div class="content-wrap">
                
                    <section class="section section-profile">
                        <div class="container">
                            <?//= AlertWidget::widget() ?>
                            <h1>Ваші історії</h1>
                            <div class="profile-controls justify">
                                <?php if(isset($moms) && $moms !== null) :?>
                                <article class="article article-profile">
                                    <div class="group">
                                        <div class="image">
                                        <?php if($moms->status != User::STATUS_WAIT) : ?>
                                            <a href="<?= Url::to(['site/story','id'=> isset($moms->id) ? $moms->id : null ]); ?>">
                                        <?php endif; ?>
                                            <img src="<?=Url::to('/web/upload/220_125/').'220_125_'.$moms->photo;?>" alt="<?= $moms->name_story; ?>">
                                        <?php if($moms->status != User::STATUS_WAIT) : ?>   
                                            </a>
                                        <?php endif; ?>
                                            <div class="image-label"><? echo $moms->nomination; ?></div>
                                        </div>
                                        <div class="text">
                                            <p><?= $moms->name_story; ?></p>
                                            <p class="article-info">
                                                <span class="icon icon-heart">
                                                <img src="<?=Url::to('/web/img/icon_heart.png');?>" alt="" />
                                                </span>
                                                <?php if($moms->status == User::STATUS_WAIT) : ?>
                                                На модерації
                                                <?php endif; ?>
                                                <?php if($moms->status != User::STATUS_WAIT) : ?>
                                                <?= $like_m; ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php if($moms->status != User::STATUS_WAIT) :?>
                                    <div class="social-box">
                                        <?php $p = Story::subStrStringMeta($moms->about); ?>

                                        <a href="javascript:void(0);" class="icon icon-social icon-fb icon-has-text active " onclick="Share.facebook('http://<?=Yii::$app->request->getServerName();?><?= Url::to(['site/story','id'=>$moms->id])?>','<?= $moms->name_story; ?>','http://<?= Yii::$app->request->getServerName(); ?><?= Url::to('/web/upload/220_125/').'220_125_'.$moms->photo; ?>','<?= $p; ?>')">
                                            <span class="icon-inner-text fb-count_<?=$moms->id;?>">0</span>
                                        </a>
                                        <a href="javascript:void(0);" class="icon icon-social icon-ok icon-has-text active" onclick="Share.odnoklassniki('http://<?=Yii::$app->request->getServerName();?><?= Url::to(['site/story','id'=>$moms->id])?>','<?= $p; ?>')">
                                            <span class="icon-inner-text odn-count_<?=$moms->id;?>">0</span>
                                        </a>
                                        <a href="javascript:void(0);" class="icon icon-social icon-vk icon-has-text active vk like l-vk " onclick="Share.vkontakte('http://<?=Yii::$app->request->getServerName();?><?= Url::to(['site/story','id'=>$moms->id])?>','<?= $moms->name_story; ?>','http://<?= Yii::$app->request->getServerName(); ?><?= Url::to('/web/upload/220_125/').'220_125_'.$moms->photo; ?>','<?= $p; ?>')">
                                            <span class="icon-inner-text l-count vk-count_<?=$moms->id;?>">0</span>
                                        </a>
                                    </div>
                                    <?php
                                    $this->registerJs(
                                        "var url = 'http://".Yii::$app->request->getServerName()."/story/".htmlspecialchars($moms->id)."';
                                            $.getJSON('http://vkontakte.ru/share.php?act=count&index=1&url='
                                                + encodeURI(url) + '&callback=?', function(response) {});
                                            $.getJSON('http://ok.ru/dk?st.cmd=extLike&uid=odklcnt0&ref='+ encodeURI(url) + '&callback=?', function(response) {});
                                    ",
                                        View::POS_READY
                                    );
                                    $this->registerJs(
                                        "Share.count_fb('http://".Yii::$app->request->getServerName()."/story/".htmlspecialchars($moms->id)."',".$moms->id.");",
                                        View::POS_LOAD
                                    );
                                    $this->registerJs(
                                        "var VK = {
                                                Share: {
                                                    count: function(value, count) {
                                                        $('.vk-count_' + ".$moms->id.").html(count);
                                                    }
                                            }
                                        }
                                        var ODKL = {
                                                updateCount: function(value, count) {
                                                        $('.odn-count_' + ".$model->id.").html(count);
                                                    }
                                                }
                                        ",
                                        View::POS_END
                                    );
                                    ?>
                                <?php endif; ?>   
                                </article>
                                <?php else : ?>
                                <!-- <a href="" class="button button-big" data-popup="#popup-3">ЗАВАНТАЖИТИ iСТОрiЮ ПРО маму</a> -->
                                <a class="button button-big">Подачу історій завершено</a>
                                <?php endif; ?>
                                <?php if(isset($bob) && $bob !== null) :?>
                                <article class="article article-profile">
                                    <div class="group">
                                        <div class="image">
                                        <?php if($moms->status != User::STATUS_WAIT) : ?>
                                            <a href="<?= Url::to(['site/story','id'=>$bob->id]); ?>">
                                        <?php endif; ?> 
                                            <img src="<?=Url::to('/web/upload/220_125/').'220_125_'.$bob->photo;?>" alt="<?= $bob->name_story; ?>">
                                        <?php if($moms->status != User::STATUS_WAIT) : ?>
                                            </a>
                                        <?php endif; ?> 
                                            <div class="image-label"><? echo $bob->nomination; ?></div>
                                        </div>
                                        <div class="text">
                                            <p><?= $bob->name_story; ?></p>
                                            <p class="article-info">
                                            <span class="icon icon-heart">
                                            <img src="<?=Url::to('/web/img/icon_heart.png');?>" alt="" />
                                            </span>
                                            <?php if($bob->status == User::STATUS_WAIT) : ?>
                                            На модерації
                                            <?php endif; ?>
                                            <?php if($bob->status != User::STATUS_WAIT) : ?>
                                            <?= $like_b; ?>
                                            <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php if($bob->status != User::STATUS_WAIT) :?>
                                    <div class="social-box">
                                        <?php $p = Story::subStrStringMeta($bob->about); ?>
                                        <a href="javascript:void(0);" class="icon icon-social icon-fb icon-has-text active " onclick="Share.facebook('http://<?=Yii::$app->request->getServerName();?><?= Url::to(['site/story','id'=>$bob->id])?>','<?= $bob->name_story; ?>','http://<?= Yii::$app->request->getServerName(); ?><?= Url::to('/web/upload/220_125/').'220_125_'.$bob->photo; ?>','<?= $p; ?>')">
                                            <span class="icon-inner-text fb-count_<?=$bob->id;?>">0</span>
                                        </a>
                                        <a href="javascript:void(0);" class="icon icon-social icon-ok icon-has-text active" onclick="Share.odnoklassniki('http://<?=Yii::$app->request->getServerName();?><?= Url::to(['site/story','id'=>$bob->id])?>','<?= $p; ?>')">
                                            <span class="icon-inner-text odn-count_<?=$bob->id;?>">0</span>
                                        </a>
                                        <a href="javascript:void(0);" class="icon icon-social icon-vk icon-has-text active  vk like l-vk" onclick="Share.vkontakte('http://<?=Yii::$app->request->getServerName();?><?= Url::to(['site/story','id'=>$bob->id])?>','<?= $bob->name_story; ?>','http://<?= Yii::$app->request->getServerName(); ?><?= Url::to('/web/upload/220_125/').'220_125_'.$bob->photo; ?>','<?= $p; ?>')">
                                            <span class="icon-inner-text l-count vk-count_<?=$bob->id;?>">0</span>
                                        </a>
                                    </div>
                                    <?php
                                    $this->registerJs(
                                        "var url = 'http://".Yii::$app->request->getServerName()."/story/".htmlspecialchars($bob->id)."';
                                            $.getJSON('http://vkontakte.ru/share.php?act=count&index=1&url='
                                                + encodeURI(url) + '&callback=?', function(response) {});
                                            $.getJSON('http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=odklcnt0&ref='
                                                + encodeURI(url), function(response) {});
                                        ",
                                        View::POS_READY
                                    );
                                    $this->registerJs(
                                        "Share.count_fb('http://".Yii::$app->request->getServerName()."/story/".htmlspecialchars($bob->id)."',".$bob->id.");",
                                        View::POS_LOAD
                                    );
                                    $this->registerJs(
                                        "var VK = {
                                                Share: {
                                                    count: function(value, count) {
                                                        $('.vk-count_' + ".$bob->id.").html(count);
                                                    }
                                            }
                                        }
                                        var ODKL = {
                                            updateCount: {
                                                count: function(value, count) {
                                                    $('.odn-count_' + ".$model->id.").html(count);
                                                }
                                            }
                                        }
                                        ",
                                        View::POS_END
                                    );
                                    ?>
                                    <?php endif; ?> 
                                </article>
                                <?php else : ?>
                                <!-- <a href="javascript:void(0);" class="button button-big" data-popup="#popup-4">ЗАВАНТАЖИТИ iСТОрiЮ ПРО Супербабуся</a> -->
                                <a class="button button-big">Подачу історій завершено</a>
                                <?php endif; ?>
                            </div>
                            <?php  if(isset($_profile) && $_profile !== null) {?>
                            <div class="profile-info-wrap justify">
                                <span class="separator"></span>
                                <div class="profile-info">
                                    <div class="heading">Ім’я</div>
                                    <?php  if(isset($_profile->name) && $_profile->name !== null) {?>
                                        <p><?= $_profile->name ?></p>
                                    <?php } ?>
                                </div>
                                <span class="separator"></span>
                                <div class="profile-info">
                                    <div class="heading">Email</div>
                                    <?php  if(isset($model->email) && $model->email !== null) {?>
                                        <p><?= $model->email ?></p>
                                    <?php } ?>
                                </div>
                                <span class="separator"></span>
                            </div>
                            <?php } ?>
                        </div>
                    </section>
                    
                </div>
               <?php $this->registerJs(
                    "var button = $('#butUpload > .if-text'), interval;
                    var button_moms = $('#butUpload_moms > .if-text'), interval;

                    new AjaxUpload(butUpload, {
                        action: '".Url::to("/components/upload.php")."', 
                        onSubmit : function(file, ext){
                        if (ext && /^(gif|jpg|png|jpeg)$/.test(ext)) {
                            $('.if-image-upload-text').text('Завантаження');
                            this.disable();
                            $('#imgLoad').show();
                            
                            interval = window.setInterval(function(){
                                var text = $('.if-image-upload-text').text();
                                
                                if (text.length < 13){
                                    $('.if-image-upload-text').text(text + '.');                    
                                } else {
                                    $('.if-image-upload-text').text('Завантаження');                
                                }
                            }, 200);
                            } else {
                                $('.if-image-error').html('Дозволені тільки gif, jpg, png файли');
                                return false;
                            }
                        },
                        onComplete: function(file, response){
                            $('#imgLoad').hide();
                            $('.help-block').html('');
                            $('.if-image-upload-text').text('Завантажено');
                            window.clearInterval(interval);
                            $('.if-image').hide();
                            $('.if-image-upload').show();
                            $('.if-images-delete').show();
                            $('.hidden-images').val(response);
                            $('.if-image-upload > img').attr('src','/web/upload/story/' + response);
                            $('<li></li>').appendTo('#files').text(file);                       
                        }
                    });

                    new AjaxUpload(button_moms, {
                        action: '".Url::to("/components/upload.php")."', 
                        onSubmit : function(file, ext){
                        if (ext && /^(gif|jpg|png|jpeg)$/.test(ext)) {
                            $('.if-image-upload-text').text('Завантаження');
                            this.disable();
                            $('#imgLoad').show();
                            
                            interval = window.setInterval(function(){
                                var text = $('.if-image-upload-text').text();
                                
                                if (text.length < 13){
                                    $('.if-image-upload-text').text(text + '.');                    
                                } else {
                                    $('.if-image-upload-text').text('Завантаження');                
                                }
                            }, 200);
                            } else {
                                $('.if-image-error').html('Дозволені тільки gif, jpg, png файли');
                                return false;
                            }
                        },
                        onComplete: function(file, response){
                            $('#imgLoad').hide();
                            $('.help-block').html('');
                            $('.if-image-upload-text').text('Завантажено');
                            window.clearInterval(interval);
                            this.disable();
                            $('.if-image').hide();
                            $('.if-image-upload').show();
                            $('.if-images-delete').show();
                            $('.hidden-images').val(response);
                            $('.if-image-upload > img').attr('src','/web/upload/story/' + response);
                            $('<li></li>').appendTo('#files').text(file);                       
                        }
                    });",
                    View::POS_READY
                ); ?>
    <?php
                $this->registerJs(
                    "function deleteAjaxImages(){

                        var images = $('.hidden-images').val();
                        var csrfToken = $('meta[name=\"csrf-token\"]').attr('content');
                        var button = $('#butUpload > .if-text'), interval;
                        var button_moms = $('#butUpload_moms > .if-text'), interval;

                        jQuery.ajax({
                        type:'POST',
                        dataType: 'json',
                        data: {images: images , _csrf : csrfToken},
                        url:'/site/uploadajax',
                        cache:false,
                        success:function(html){
                            if(html == 'success'){
                                $('.if-image').show();
                                $('.if-image-upload').hide();
                                $('.if-images-delete').hide();
                                $('.if-image-upload-text').html('Завантажити <br />фото номінанта');
                                $('.hidden-images').val('');

                        new AjaxUpload(butUpload, {
                            action: '".Url::to("/components/upload.php")."', 
                            onSubmit : function(file, ext){
                            if (ext && /^(gif|jpg|png)$/.test(ext)) {
                                $('.if-image-upload-text').text('Завантаження');
                                this.disable();
                                $('#imgLoad').show();
                                
                                interval = window.setInterval(function(){
                                    var text = $('.if-image-upload-text').text();
                                    
                                    if (text.length < 13){
                                        $('.if-image-upload-text').text(text + '.');                    
                                    } else {
                                        $('.if-image-upload-text').text('Завантаження');                
                                    }
                                }, 200);
                                } else {
                                    $('.if-image-error').html('Дозволені тільки gif, jpg, png файли');
                                    return false;
                                }
                            },
                            onComplete: function(file, response){
                                $('#imgLoad').hide();
                                $('.help-block').html('');
                                $('.if-image-upload-text').text('Завантажено');
                                window.clearInterval(interval);
                                this.disable();
                                $('.if-image').hide();
                                $('.if-image-upload').show();
                                $('.if-images-delete').show();
                                $('.hidden-images').val(response);
                                $('.if-image-upload > img').attr('src','/web/upload/story/' + response);
                                $('<li></li>').appendTo('#files').text(file);                       
                            }
                        });

                        new AjaxUpload(button_moms, {
                            action: '".Url::to("/components/upload.php")."', 
                            onSubmit : function(file, ext){
                            if (ext && /^(gif|jpg|png|jpeg)$/.test(ext)) {
                                $('.if-image-upload-text').text('Завантаження');
                                this.disable();
                                $('#imgLoad').show();
                                
                                interval = window.setInterval(function(){
                                    var text = $('.if-image-upload-text').text();
                                    
                                    if (text.length < 13){
                                        $('.if-image-upload-text').text(text + '.');                    
                                    } else {
                                        $('.if-image-upload-text').text('Завантаження');                
                                    }
                                }, 200);
                                } else {
                                    $('.if-image-error').html('Дозволені тільки gif, jpg, png файли');
                                    return false;
                                }
                            },
                            onComplete: function(file, response){
                                $('#imgLoad').hide();
                                $('.help-block').html('');
                                $('.if-image-upload-text').text('Завантажено');
                                window.clearInterval(interval);
                                this.disable();
                                $('.if-image').hide();
                                $('.if-image-upload').show();
                                $('.if-images-delete').show();
                                $('.hidden-images').val(response);
                                $('.if-image-upload > img').attr('src','/web/upload/story/' + response);
                                $('<li></li>').appendTo('#files').text(file);                       
                            }
                        });



                            }
                        }
                        });
                    }",
                    View::POS_END
                );

    ?>