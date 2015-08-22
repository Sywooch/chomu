<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property string $id
 * @property string $keywords
 * @property string $description
 * @property string $email
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','keywords', 'description', 'email','images'], 'string', 'max' => 255],
            [['images'], 'file', 'skipOnEmpty' => true, 'message'=>'Це поле є обов’язковим для заповнення'],
            [['images'], 'file', 'extensions' => 'gif, jpg, png', 'wrongExtension'=>'Дозволені тільки gif, jpg, png файли ', ],
            [['images'], 'file', 'maxSize' => 1024 * 1024 * 5 , 'tooBig'=>'Максимальний розмір файлу 5mb'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'SEO - Заголовок',
            'keywords' => 'SEO - Ключевые слова',
            'description' => 'SEO - Описание',
            'email' => 'E-mail',
            'images' => 'og:images',
        ];
    }

    /**
     * @inheritdoc
     * @return SeoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeoQuery(get_called_class());
    }
}
