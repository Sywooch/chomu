<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%questions}}".
 *
 * @property string $id
 * @property string $questions
 * @property integer $yes
 * @property integer $no
 * @property string $vote
 * @property integer $sort
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%questions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['questions', 'yes', 'no', 'vote', 'sort'], 'required'],
            [['yes', 'no', 'sort'], 'integer'],
            [['questions', 'vote'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'questions' => 'Questions',
            'yes' => 'Yes',
            'no' => 'No',
            'vote' => 'Vote',
            'sort' => 'Sort',
        ];
    }

    /**
     * @inheritdoc
     * @return QuestionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionsQuery(get_called_class());
    }
}
