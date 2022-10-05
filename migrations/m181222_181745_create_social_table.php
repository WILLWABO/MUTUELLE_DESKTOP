<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contribution`.
 */
class m181222_181745_create_social_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('social', [
            'id' => $this->primaryKey()->unsigned(),
            'amount' => $this->integer(10)->unsigned(),
            'member_id' => $this->integer()->unsigned(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'administrator_id' => $this->integer()->unsigned(),
            'session_id' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('social');
    }
}
