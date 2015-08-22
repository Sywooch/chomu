<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * No.
 */
class No extends Model
{
	public $no_one;
    public $no_two;
	public $no_three;
    public $no_four;
    public $no_five;

    /**
     * @return array the validation rules.
     */
  	public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'no_one' => 'Не вірю у зміни',
            'no_two' => 'Результат відомий заздалегідь',
            'no_three' => 'Не хочу витрачати свій час та сили',
            'no_four' => 'Від мене нічого не залежить',
            'no_five' => 'Важко визначитись із кандидатом',
        ];
    }
}