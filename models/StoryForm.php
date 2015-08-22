<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%story}}".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $nomination
 * @property string $name_story
 * @property string $photo
 * @property string $about
 * @property string $author
 * @property string $date
 * @property string $type
 * @property integer $like
 * @property integer $status
 */
class StoryForm extends \yii\db\ActiveRecord
{

    public $rules;
    const DATE_FORMAT = 'php:Y-m-d';
    const DATETIME_FORMAT = 'php:Y-m-d H:i:s';
    const TIME_FORMAT = 'php:H:i:s';
 
     public  $user_id;
     public  $name;
     public  $last_name;
     public  $phone;
     public  $email;
     public  $nomination;
     public  $name_story;
     public  $photo_bob;
     public  $about;
     public  $author;
     public  $date;
     public  $type;
     public  $like;
     public  $status;

    public function rules()
    {
        return [
            [['name', 'last_name', 'phone', 'email', 'nomination', 'name_story', 'about', 'photo_bob'], 'required' , 'message' => 'Це поле є обов’язковим для заповнення'],
            [['user_id', 'like', 'status', 'type'], 'integer'],
            [['about'], 'string'],
            [['date', 'name', 'last_name', 'phone', 'email', 'nomination', 'name_story', 'about', 'photo_bob'], 'safe'],
            [['name', 'last_name', 'phone', 'email', 'nomination', 'name_story', 'author'], 'string', 'max' => 255],
            ['email', 'filter', 'filter' => 'trim', 'message' => 'Введіть коректну E-mail адресу'],
            ['email', 'email', 'message' => 'Введіть коректну E-mail адресу'],
            [['phone'], 'string', 'max' => 30, 'tooLong'=>'Ведіть корректні дані'],
            [['phone'], 'udokmeci\yii2PhoneValidator\PhoneValidator','country'=>'UA', 'message' => 'Введено невірний формат телефону'],
            ['rules', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            [['rules'], 'integer', 'min' => 1, 'tooSmall'=>'Ви повинні прийняти правила'],
            /*[['photo_bob'], 'file', 'skipOnEmpty' => true, 'message'=>'Це поле є обов’язковим для заповнення'],
            [['photo_bob'], 'file', 'extensions' => 'gif, jpg, png', 'wrongExtension'=>'Дозволені тільки gif, jpg, png файли ', ],
            [['photo_bob'], 'file', 'maxSize' => 1024 * 1024 * 5 , 'tooBig'=>'Максимальний розмір файлу 5mb'],*/
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Ім`я',
            'last_name' => 'Прізвище',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'nomination' => 'Номінація',
            'name_story' => 'Назва історії',
            'photo_bob' => 'Фото',
            'about' => 'Роскажіть вашу історію',
            'author' => 'Автор',
            'date' => 'Date',
            'type' => 'Type',
            'like' => 'Like',
            'status' => 'Status',
            'rules' => 'Номінант не заперечує проти використання своїх даних',
        ];
    }
}
