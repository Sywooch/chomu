<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property string $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $h1
 * @property string $content
 * @property integer $commit
 * @property string $created
 * @property integer $status
 */
class Article extends \yii\db\ActiveRecord
{


    public static $status = [
        '' => '',
        '0' => 'Закрыто',
        '1' => 'Открыто',
    ];


    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'h1', 'content'], 'required'],
            [['keywords', 'description', 'content','pre_content'], 'string'],
            [['commit', 'status', 'type'], 'integer'],
            [['created','url'], 'safe'],
            [['title', 'h1','url'], 'string', 'max' => 255],
            [['photo','images'], 'file', 'skipOnEmpty' => true, 'message'=>'Це поле є обов’язковим для заповнення'],
            [['photo','images'], 'file', 'extensions' => 'gif, jpg, png', 'wrongExtension'=>'Дозволені тільки gif, jpg, png файли ', ],
            [['photo','images'], 'file', 'maxSize' => 1024 * 1024 * 5 , 'tooBig'=>'Максимальний розмір файлу 5mb'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'keywords' => 'SEO - Ключевые слова',
            'description' => 'SEO - Описание',
            'h1' => 'h1 - Заголовок',
            'content' => 'Текст',
            'commit' => 'Commit',
            'created' => 'Дата',
            'status' => 'Статус',
            'url' => 'url',
            'photo' => 'Привью фото',
            'type' => 'Тип новостей',
            'pre_content' => 'Привью новости',
            'images' => 'Фото новости заглавное.'
        ];
    }

    /**
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
