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

        $user = User::findOne(['social_id' => Yii::$app->user->identity->social_id]);

        $vote               = new Vote();
        $vote->user_id      = $user->id;
        $vote->questions_id = Yii::$app->session->get('question_id');
        $vote->vote         = 1;
        $vote->save();

        return true;
    }

    public static function getResult()
    {
        $result = [
            'yes'       => [
                'count'   => 1,
                'percent' => 0
            ],
            'no'        => [
                'count'   => 1,
                'percent' => 0
            ],
            'questions' => [
            /* '2' => [
              'count',
              'percent'
              ], */
            ]
        ];

        $votes     = self::find()->all();
        $questions = Questions::find()->all();
        //$votes = self::find()->leftJoin($result);

        foreach ($questions as $key => $value) {
            $result['questions'][$value->id] = [
                'count'   => '0',
                'percent' => '0',
                'group'   => (!empty($value->yes)) ? 'yes' : 'no'
            ];
        }

        foreach ($votes as $key => $vote) {

            $result['questions'][$vote->questions_id]['count'] = $result['questions'][$vote->questions_id]['count']
                + 1;

            if ('yes' == $result['questions'][$vote->questions_id]['group']) {
                $result['yes']['count'] ++;

                $result['questions'][$vote->questions_id]['count']   = $result['questions'][$vote->questions_id]['count']
                    + 1;
                $result['questions'][$vote->questions_id]['percent'] = ($result['questions'][$vote->questions_id]['count']
                    / $result['yes']['count']) * 100;
            }

            if ('no' == $result['questions'][$vote->questions_id]['group']) {
                $result['no']['count'] ++;

                $result['questions'][$vote->questions_id]['count']   = $result['questions'][$vote->questions_id]['count']
                    + 1;
                $result['questions'][$vote->questions_id]['percent'] = ($result['questions'][$vote->questions_id]['count']
                    / $result['no']['count']) * 100;
            }
        }

        /*echo '<pre>';
        print_r($result);
        die();*/

        return $result;
    }
}