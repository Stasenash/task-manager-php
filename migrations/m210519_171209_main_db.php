<?php

use yii\db\Migration;

/**
 * Class m210519_171209_main_db
 */
class m210519_171209_main_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210519_171209_main_db cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210519_171209_main_db cannot be reverted.\n";

        return false;
    }
    */
}
