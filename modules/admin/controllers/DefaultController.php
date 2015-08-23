<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class'        => AccessControl::className(),
                'rules'        => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                $this->redirect('/');
            }
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $this->layout = 'admin';
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function SlugHelperUrl($text)
    {
        $matrix = array(
            "й" => "i", "ц" => "c", "у" => "u", "к" => "k", "е" => "e", "н" => "n",
            "г" => "g", "ш" => "sh", "щ" => "sh", "з" => "z", "х" => "h", "ъ" => "\'",
            "ф" => "f", "ы" => "i", "в" => "v", "а" => "a", "п" => "p", "р" => "r",
            "о" => "o", "л" => "l", "д" => "d", "ж" => "zh", "э" => "ie", "ё" => "e",
            "я" => "ya", "ч" => "ch", "с" => "s", "м" => "m", "и" => "i", "т" => "t",
            "ь" => "\'", "б" => "b", "ю" => "yu", "і" => "i", "ї" => "i",
            "Й" => "I", "Ц" => "C", "У" => "U", "К" => "K", "Е" => "E", "Н" => "N",
            "Г" => "G", "Ш" => "SH", "Щ" => "SH", "З" => "Z", "Х" => "X", "Ъ" => "\'",
            "Ф" => "F", "Ы" => "I", "В" => "V", "А" => "A", "П" => "P", "Р" => "R",
            "О" => "O", "Л" => "L", "Д" => "D", "Ж" => "ZH", "Э" => "IE", "Ё" => "E",
            "Я" => "YA", "Ч" => "CH", "С" => "S", "М" => "M", "И" => "I", "Т" => "T",
            "Ь" => "\'", "Б" => "B", "Ю" => "YU", "І" => "I", "Ї" => "I",
            "«" => "", "»" => "", " " => "-",
        );
        foreach ($matrix as $from => $to)
            $text   = mb_eregi_replace($from, $to, $text);
        $text   = preg_replace('/[^A-Za-z0-9_\-]/', '', $text);

        return trim(strtolower($text));
    }
}