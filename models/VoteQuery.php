<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Questions]].
 *
 * @see Questions
 */
class VoteQuery extends \yii\db\ActiveQuery
{
    /* public function active()
      {
      $this->andWhere('[[status]]=1');
      return $this;
      } */

    /**
     * @inheritdoc
     * @return Questions[]|array
     */
    public function yesOnly()
    {
        $this->leftJoin('{{questions}}', '{{questions}}.id = {{vote}}.questions_id');
        $this->andWhere('{{questions.yes}} = "1"');

        return $this;
    }

    /**
     * @inheritdoc
     * @return Questions[]|array
     */
    public function noOnly()
    {
        $this->leftJoin('{{questions}}', '{{questions}}.id = {{vote}}.questions_id');
        $this->andWhere('{{questions.no}} = "1"');

        return $this;
    }
}