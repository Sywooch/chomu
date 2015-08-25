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
class Subscribes extends \yii\db\ActiveRecord
{
    public static $status = [
        ''  => '',
        '0' => 'Неподтвержден',
        '1' => 'Подтвержден',
    ];

    public static function tableName()
    {
        return '{{%subscribes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
//            [['email'], 'unique'],
            [['email'], 'email'],
            [['status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'     => 'ID',
            'email'  => 'Email',
            'status' => 'Status',
        ];
    }
}