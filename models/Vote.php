<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%vote}}".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $story_id
 * @property integer $like
 */
class Vote extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vote}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'questions_id', 'vote'], 'safe'],
            [['user_id', 'questions_id', 'vote'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'user_id'      => 'User ID',
            'questions_id' => 'Type',
            'vote'         => 'Like',
        ];
    }

    public static function checkoutUserId($id)
    {
        if (isset($id) && $id !== null) {
            $model = self::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['questions_id' => $id])->one();
            return $model;
        } else return false;
    }

    public static function processVote()
    {
        if (!Yii::$app->session->get('question_id')) return false;

        $user = User::findOne(['social_id' == Yii::$app->user->identity->social_id]);

        //print_r(Yii::$app->user->id); die();

        $vote              = new Vote();
        $vote->user_id     = $user->id;
        $vote->questions_id = Yii::$app->session->get('question_id');
        $vote->vote        = 1;
        $vote->save();

        return true;
    }
}