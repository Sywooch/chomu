<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/config/web.php');

if (!empty($_GET['fix_env']) or !empty($_COOKIE['fix_env'])) {
    setcookie('fix_env','1');
    $config = require(__DIR__ . '/config/fix.php');
    echo 'fix env<br>';
}

(new yii\web\Application($config))->run();
