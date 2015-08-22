<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%issue}}".
 *
 * @property string $id
 * @property string $yes
 * @property string $no
 * @property string $sum
 * @property string $plus
 */
class Issue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%issue}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['yes', 'no', 'sum', 'plus'], 'required'],
            [['yes', 'no', 'sum', 'plus'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'yes' => 'Yes',
            'no' => 'No',
            'sum' => 'Sum',
            'plus' => 'Добавление в счетчик голосов',
        ];
    }

    /**
     * @inheritdoc
     * @return IssueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IssueQuery(get_called_class());
    }
}
