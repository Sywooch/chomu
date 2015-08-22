<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Faq]].
 *
 * @see Faq
 */
class FaqQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Faq[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Faq|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}