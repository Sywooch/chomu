<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAssetAdmin;
//mihaildev\elfinder\Assets::noConflict($this);

\app\assets\AppAssetAdmin::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => array_filter([                    
                    ['label' => 'Вопросы', 'url' => ['/admin/questions']],
                    ['label' => 'Пользователи', 'url' => ['/admin/user']],
                    ['label' => 'Голоса', 'url' => ['/admin/vote']],
                    ['label' => 'Другие ответы', 'url' => ['/admin/vote/custom-answer']],
                    ['label' => 'Контент', 'url' => ['/admin/content']],
                    ['label' => 'Новости', 'url' => ['/admin/article']],
                    ['label' => 'Подписки', 'url' => ['/admin/subscribes']],
                    ['label' => 'Настройки', 'url' => ['/admin/seo']],
                    ['label' => 'Logout',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ]),
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Chomu.net <?= date('Y') ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
