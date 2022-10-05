<?php

use yii\db\Migration;

/**
 * Class m201222_181934_set_foreign_keys
 */
class m201222_181934_set_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('member_user_id','member','user_id','user','id');
        $this->addForeignKey('member_session_id','member','session_id','session','id');
        $this->addForeignKey('member_administrator_id','member','administrator_id','administrator','id');
        
        $this->addForeignKey('administrator_user_id','administrator','user_id','user','id');

        $this->addForeignKey('saving_member_id','saving','member_id','member','id');
        $this->addForeignKey('saving_administrator_id','saving','administrator_id','administrator','id');
        $this->addForeignKey('saving_session_id','saving','session_id','session','id');

        $this->addForeignKey('borrowing_saving_borrowing_id','borrowing_saving','borrowing_id','borrowing','id');
        $this->addForeignKey('borrowing_saving_saving_id','borrowing_saving','saving_id','saving','id');

        $this->addForeignKey('borrowing_administrator_id','borrowing','administrator_id','administrator','id');
        $this->addForeignKey('borrowing_member_id','borrowing','member_id','member','id');
        $this->addForeignKey('borrowing_session_id','borrowing','session_id','session','id');

        $this->addForeignKey('exercise_administrator_id','exercise','administrator_id','administrator','id');


        $this->addForeignKey('session_administrator_id','session','administrator_id','administrator','id');
        $this->addForeignKey('session_exercise_id','session','exercise_id','exercise','id');

        $this->addForeignKey('refund_borrowing_id','refund','borrowing_id','borrowing','id');
        $this->addForeignKey('refund_administrator_id','refund','administrator_id','administrator','id');
        $this->addForeignKey('refund_session_id','refund','session_id','session','id');
        $this->addForeignKey('refund_exercise_id','refund','exercise_id','exercise','id');
        $this->addForeignKey('refund_member_id','refund','member_id','member','id');

        $this->addForeignKey('help_administrator_id','help','administrator_id','administrator','id');
        $this->addForeignKey('help_help_type_id','help','help_type_id','help_type','id');
        $this->addForeignKey('help_member_id','help','member_id','member','id');
        $this->addForeignKey('help_session_id','help','session_id','session','id');
        
        $this->addForeignKey('contribution_help_id','contribution','help_id','help','id');
        $this->addForeignKey('contribution_member_id','contribution','member_id','member','id');
        $this->addForeignKey('contribution_administrator_id','contribution','administrator_id','administrator','id');
        $this->addForeignKey('contribution_session_id','contribution','session_id','session','id');

        $this->addForeignKey('tontine_member_id','tontine','member_id','member','id');
        $this->addForeignKey('tontine_administrator_id','tontine','administrator_id','administrator','id');
        $this->addForeignKey('tontine_session_id','tontine','session_id','session','id');
        $this->addForeignKey('tontine_categorie_id','tontine','categorie_id','categorie','id');
        
        $this->addForeignKey('categorie_member_id','categorie','member_id','member','id');
        $this->addForeignKey('categorie_session_id','categorie','session_id','session','id');
        $this->addForeignKey('categorie_administrator_id','categorie','administrator_id','administrator','id');
        
        $this->addForeignKey('social_member_id','social','member_id','member','id');
        $this->addForeignKey('social_session_id','social','session_id','session','id');
        $this->addForeignKey('social_administrator_id','social','administrator_id','administrator','id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201222_181934_set_foreign_keys cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_181934_set_foreign_keys cannot be reverted.\n";

        return false;
    }
    */
}
