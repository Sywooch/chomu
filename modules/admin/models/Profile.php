<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $name
 * @property string $last_name
 * @property string $phone
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'last_name', 'phone'], 'required'],
            [['user_id'], 'integer'],
            [['name', 'last_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30, 'tooLong'=>'Ведіть корректні дані'],
            [['phone'], 'udokmeci\yii2PhoneValidator\PhoneValidator','country'=>'UA', 'message' => 'Введено невірний формат телефону'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Ім`я',
            'last_name' => 'Прізвище',
            'phone' => 'Телефон',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }

    public static function getProfile($id){
        if(isset($id)) return self::find()->where('user_id = :user_id', [':user_id' => $id])->one();
            return false;
    }

    /**
     * @inheritdoc
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }
}
