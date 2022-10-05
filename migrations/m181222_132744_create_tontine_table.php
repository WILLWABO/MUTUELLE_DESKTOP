<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tontine`.
 */
class m181222_132744_create_tontine_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tontine', [
            'id' => $this->primaryKey(),
            'amount' => $this->integer(10)->unsigned(),
            'categorie_id' => $this->integer(10)->unsigned(),
            'member_id'=> $this->integer()->unsigned(),
            'administrator_id' => $this->integer()->unsigned(),
            'session_id' => $this->integer()->unsigned(),
            'categorie_id' => $this->integer()->unsigned(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tontine');
    }
}
