<?php

use yii\db\Migration;

/**
 * Class m211113_111422_store_product
 */
class m211113_111422_store_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%store_product}}', [
            'id' => $this->primaryKey(),
            'store_id' => $this->integer(),
            'upc' => $this->string(32)->notNull(),
            'title' => $this->string()->null(),
            'price' => $this->double()->null()->defaultValue(0),
        ]);

        $this->addForeignKey('store_id', '{{%store_product}}', 'store_id', '{{%store}}', 'id', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%store_product}}');
    }
}
