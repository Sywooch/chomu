<?php

namespace app\models;

use Yii;
use app\models\VoteQuery;

/**
 * This is the model class for table "{{%vote}}".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $questions_id
 * @property integer $vote
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
            'questions_id' => 'Question ID',
            'vote'         => 'Votes',
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
                'count'   => 0,
                'percent' => 0
            ],
            'no'        => [
                'count'   => 0,
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
        $result['yes']['count'] = Vote::find()->yesOnly()->count();
        $result['no']['count'] = Vote::find()->noOnly()->count();
        $totalCount = $result['yes']['count'] + $result['no']['count'];
        $result['yes']['percent'] = ($result['yes']['count'] / $totalCount) * 100;
        $result['no']['percent'] = ($result['no']['count'] / $totalCount) * 100;

        //print_r($noCount);
        //die();
        //$votes = self::find()->leftJoin($result);
        //$this->leftJoin('{{promo_categories}}', '{{promo_categories}}.promo_id = {{%promo}}.id');
        //$this->andWhere('{{promo_categories.category_id}} = "'.$ids.'"');

        foreach ($questions as $key => $value) {
            $result['questions'][$value->id] = [
                'count'   => '0',
                'percent' => '0',
                'group'   => (!empty($value->yes)) ? 'yes' : 'no'
            ];
        }

        foreach ($votes as $key => $vote) {
            if ('yes' == $result['questions'][$vote->questions_id]['group']) {
                $result['questions'][$vote->questions_id]['count']   = $result['questions'][$vote->questions_id]['count']
                    + 1;
                $result['questions'][$vote->questions_id]['percent'] = ($result['questions'][$vote->questions_id]['count']
                    / $result['yes']['count']) * 100;
            }

            if ('no' == $result['questions'][$vote->questions_id]['group']) {
                $result['questions'][$vote->questions_id]['count']   = $result['questions'][$vote->questions_id]['count']
                    + 1;
                $result['questions'][$vote->questions_id]['percent'] = ($result['questions'][$vote->questions_id]['count']
                    / $result['no']['count']) * 100;
            }
        }

         /*echo '<pre>';
          print_r($result);
          die(); */

        return $result;
    }

    /**
     * @inheritdoc
     * @return QuestionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VoteQuery(get_called_class());
    }
}