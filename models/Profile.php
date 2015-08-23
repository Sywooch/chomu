<?php

namespace app\models;

use Yii;
use app\models\User;

class Profile extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%profile}}';
    }

    public function rules()
    {
        return [
            //[['name', 'last_name', 'phone'], 'required'],
            [['name'], 'required'],
            [['user_id'], 'integer'],
            [['name', 'last_name', 'age', 'city', 'photo', 'thumb_photo'], 'string', 'max' => 255],
            //[['phone'], 'string', 'max' => 30, 'tooLong'=>'Ведіть корректні дані'],
            //[['phone'], 'udokmeci\yii2PhoneValidator\PhoneValidator','country'=>'UA', 'message' => 'Введено невірний формат телефону'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'user_id'     => 'User ID',
            'name'        => 'Ім`я',
            'last_name'   => 'Прізвище',
            'phone'       => 'Телефон',
            'age'         => 'Вік',
            'city'        => 'Місто',
            'photo'       => 'Фото',
            'thumb_photo' => 'Мини фото',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProfile()
    {
        return self::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->one();
    }

    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }

    public static function socialSave($user, $info)
    {
        $prof          = new Profile();
        $prof->user_id = $user->id;
        $prof->name    = $info['name'];

        if (!empty($info['photo_rec'])) {
            $prof->thumb_photo = $info['photo_rec'];
        }

        if (!empty($info['photo'])) {
            $prof->photo = $info['photo_big'];
        }
        if (!empty($info['first_name'])) {
            $prof->name = $info['first_name'];
        }

        if (!empty($info['last_name'])) {
            $prof->last_name = $info['last_name'];
        }

        $prof->save(false);

        echo '<pre>';
        print_r($info);
        die();
    }
}