<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property integer $status
 */
class Faq extends \yii\db\ActiveRecord
{

    public static $status = [
        '' => '',
        '0' => 'Закрыто',
        '1' => 'Открыто',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status'], 'required'],
            [['content'], 'string'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'content' => 'Текст',
            'status' => 'Статус',
        ];
    }

    /**
     * @inheritdoc
     * @return FaqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaqQuery(get_called_class());
    }
}
