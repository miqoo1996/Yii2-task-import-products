<?php

use yii\db\Migration;
use common\models\Store;

/**
 * Class m211113_111431_seed_store_tables
 */
class m211113_111431_seed_store_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $model = new Store();

        for ($i = 1; $i <= 20; $i++) {
            $modelCloned = clone $model;
            $modelCloned->setAttributes(['title' => 'Store' . $i]);
            $modelCloned->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211113111431_seed_store_tables cannot be reverted.\n";

        return false;
    }
}
