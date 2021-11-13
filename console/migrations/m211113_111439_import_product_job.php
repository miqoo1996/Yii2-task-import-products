<?php

use yii\db\Migration;

/**
 * Class m211113_111439_import_product_job
 */
class m211113_111439_import_product_job extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%import_product_job}}', [
            'id' => $this->primaryKey(),
            'store_id' => $this->integer(),
            'status' => $this->string(),
            'data' => $this->json()->null(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%import_product_job}}');
    }
}
