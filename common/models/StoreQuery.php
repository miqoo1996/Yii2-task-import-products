<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Store]].
 *
 * @see Store
 */
class StoreQuery extends \yii\db\ActiveQuery
{
    /**
     * @param string|null $title
     */
    public function findByTitle(?string $title = null) :? string
    {
        $title = $title ?: $this->title;

        return $this->andWhere(['title' => $title]);
    }

    /**
     * {@inheritdoc}
     * @return Store[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Store|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
