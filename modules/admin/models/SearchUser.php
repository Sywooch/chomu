<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * SearchUser represents the model behind the search form about `app\modules\admin\models\User`.
 */
class SearchUser extends User
{
    /**
     * @inheritdoc
     */
     public $name;
    // public $last_name;

    /*public function attributes()
    {
        // add related fields to searchable attributes
      return array_merge(parent::attributes(), ['Name.name']);

    }*/

    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['username', 'name', 'auth_key', 'email_confirm_token', 'password_hash', 'password_reset_token', 'email','last_name','age','city','social_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        //$query->joinWith(['name']);
        //$query = User::find()->select(['user.*', 'vote.user_id','vote.story_id','vote.like','story.name_story','story.email AS story_email'])->leftJoin('vote', 'vote.user_id=user.id')->leftJoin('story', 'story.id=vote.story_id')->where("story.status = 1")->orderBy('story.id ASC');
        //$query = User::find()->select(['user.*', 'profile.name','profile.last_name'])->leftJoin('profile', 'profile.user_id=user.id')->orderBy('user.id ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
                return $dataProvider;
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'name' => $this->name,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            //->andFilterWhere(['like', 'profile.name', $this->name])
            //->andFilterWhere(['like', 'profile.last_name', $this->last_name])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'email_confirm_token', $this->email_confirm_token])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'social_id', $this->social_id])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
