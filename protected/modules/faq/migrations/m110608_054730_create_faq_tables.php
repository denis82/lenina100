<?php

class m110608_054730_create_faq_tables extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{faq}}', array(
            'id' => 'pk',
            'name_q' => 'string NOT NULL',
            'email' => 'string NOT NULL',
            'quest' => 'text NOT NULL',
            'name_a' => 'string NOT NULL',
            'answer' => 'text NOT NULL',
            'status' => 'string NOT NULL DEFAULT "faq_pending"',
            'visible' => 'string NOT NULL DEFAULT "faq_hidden"',
            'weight' => 'integer NOT NULL DEFAULT 0',
            'category_id' => 'integer NOT NULL',
            'create_time' => 'integer NOT NULL',
            'update_time' => 'integer NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('{{faq_category}}', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'url' => 'string NOT NULL',
            'weight' => 'integer NOT NULL DEFAULT 0',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
	}

	public function down()
	{
	    $this->dropTable('{{faq_category}}');
		$this->dropTable('{{faq}}');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
