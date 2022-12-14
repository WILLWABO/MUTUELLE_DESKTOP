<?php

use yii\db\Migration;

/**
 * Class m201227_125715_seed_help_types
 */
class m201227_125715_seed_help_types extends Migration
{
    /**
     * {@inheritdoc}
     */

    private $helps = [
        'Membre malade' => 200000,
        'Naissance' => 50000,
        'Décès d\'un membre' => 1000000,
        'Décès du parent d\'un membre' => 0,
        'Décès de l\'enfant d\'un membre' =>300000,
        'Décès conjoint' =>500000,
        'Départ à la retraite' =>500000,
        'Mariage d\'un membre' => 100000,
        'Promotion d\'un membre' => 50000,
    ];

    public function safeUp()
    {
        foreach ($this->helps as $title => $amount) {
            $help = new \app\models\HelpType();
            $help->title = $title;
            $help->amount = $amount;
            $help->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201227_125715_seed_help_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201227_125715_seed_help_types cannot be reverted.\n";

        return false;
    }
    */
}
