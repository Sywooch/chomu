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

        if (!empty(Yii::$app->session->get('answer'))) {
            $vote->custom_answer = Yii::$app->session->get('answer');
        }

        $vote->save();

        return true;
    }

    public static function getResult()
    {
        $result = [];

        //get from db
        $votes                  = self::find()->all();
        $questions              = Questions::find()->all();

        //add custom questions
        $customYes = new Questions();
        $customYes->id = 1000001;
        $customYes->questions = 'Iншi';
        $customYes->yes = 1;
        $questions[] = $customYes;

        $customNo = new Questions();
        $customNo->id = 1000002;
        $customNo->questions = 'Iншi';
        $customNo->no = 1;
        $questions[] = $customNo;

        //total
        $result['yes']['count'] = Vote::find()->yesOnly()->count();
        $result['no']['count']  = Vote::find()->noOnly()->count();

        //get total count
        foreach ($questions as $key => $value) {
            if (!empty($value->yes)) {
                $result['yes']['count'] += $value->vote;
            }

            if (!empty($value->no)) {
                $result['no']['count'] += $value->vote;
            }
        }

        //set total values
        $totalCount               = $result['yes']['count'] + $result['no']['count'];
        $result['yes']['percent'] = round(($result['yes']['count'] / $totalCount)
            * 100);
        $result['no']['percent']  = round(($result['no']['count'] / $totalCount)
            * 100);

        //set percent
        foreach ($questions as $key => $value) {
              $result['questions'][$value->id] = [
                'count'   => $value->vote,
                'vote'    => $value->vote
            ];

            if (!empty($value->yes)) {
                $result['questions'][$value->id]['group'] = 'yes';
                $result['questions'][$value->id]['percent'] = round(($result['questions'][$value->id]['count']
                    / $result['yes']['count']) * 100);
            }

            if (!empty($value->no)) {
                $result['questions'][$value->id]['group'] = 'no';
                $result['questions'][$value->id]['percent'] = round(($result['questions'][$value->id]['count']
                    / $result['no']['count']) * 100);
            }
        }

        //add each vote to array
        foreach ($votes as $key => $vote) {
            if ('yes' == $result['questions'][$vote->questions_id]['group']) {
                $result['questions'][$vote->questions_id]['count']   = $result['questions'][$vote->questions_id]['count']
                    + 1;
                $result['questions'][$vote->questions_id]['percent'] = round(($result['questions'][$vote->questions_id]['count']
                    / $result['yes']['count']) * 100);
            }

            if ('no' == $result['questions'][$vote->questions_id]['group']) {
                $result['questions'][$vote->questions_id]['count']   = $result['questions'][$vote->questions_id]['count']
                    + 1;
                $result['questions'][$vote->questions_id]['percent'] = round(($result['questions'][$vote->questions_id]['count']
                    / $result['no']['count']) * 100);
            }
        }

                //set smile
        foreach ($questions as $key => $value) {
            $result['questions'][$value->id]['smile'] = 10 - round($result['questions'][$value->id]['percent']/10);
            if ( $result['questions'][$value->id]['smile'] < 1)  {
                $result['questions'][$value->id]['smile'] = 1;
            }
        }

        /*echo '<pre>';
        print_r($result);

        die();*/

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