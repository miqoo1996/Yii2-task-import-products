<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StoreProduct]].
 *
 * @see StoreProduct
 */
class StoreProductQuery extends \yii\db\ActiveQuery
{
    /**
     * @param string $upc
     * @return self
     */
    public function filterUpc(string $upc) : self
    {
        return $this->andWhere(['upc' => $upc]);
    }

    /**
     * {@inheritdoc}
     * @return StoreProduct[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StoreProduct|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
