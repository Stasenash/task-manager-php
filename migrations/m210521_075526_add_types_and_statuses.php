<?php

use yii\db\Migration;

/**
 * Class m210521_075526_add_types_and_statuses
 */
class m210521_075526_add_types_and_statuses extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('type', array('name'=>'development'));
        $this->insert('type', array('name'=>'bug'));
        $this->insert('type', array('name'=>'sales'));
        $this->insert('type', array('name'=>'research'));

        $this->insert('status', array('name'=>"к выполнению"));
        $this->insert('status', array('name'=>"в работе"));
        $this->insert('status', array('name'=>"тестирование"));
        $this->insert('status', array('name'=>"приемка"));
        $this->insert('status', array('name'=>"готово"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210521_075526_add_types_and_statuses cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210521_075526_add_types_and_statuses cannot be reverted.\n";

        return false;
    }
    */
}
