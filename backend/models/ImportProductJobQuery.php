<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ImportProductJob]].
 *
 * @see ImportProductJob
 */
class ImportProductJobQuery extends \yii\db\ActiveQuery
{
    public function status($status = ImportProductJob::STATUS_NEW)
    {
        return $this->andWhere(['status' => $status]);
    }

    /**
     * {@inheritdoc}
     * @return ImportProductJob[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ImportProductJob|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
