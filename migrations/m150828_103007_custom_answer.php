<?php

use yii\db\Schema;
use yii\db\Migration;

class m150828_103007_custom_answer extends Migration
{
    public function up()
    {
        $this->addColumn('{{%vote}}', 'custom_answer', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150828_103007_custom_answer cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
