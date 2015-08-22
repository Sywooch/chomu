<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Yes.
 */
class Yes extends Model
{
	public $yes_one;
    public $yes_two;
	public $yes_three;
    public $yes_four;
    public $yes_five;

    public function attributeLabels()
    {
        return [
            'yes_one' => 'Не вірю у зміни',
            'yes_two' => 'Результат відомий заздалегідь',
            'yes_three' => 'Не хочу витрачати свій час та сили',
            'yes_four' => 'Від мене нічого не залежить',
            'yes_five' => 'Важко визначитись із кандидатом',
        ];
    }
}