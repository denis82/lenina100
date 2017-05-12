<?php

class m120307_110019_create_table_config extends CDbMigration
{
	public function up()
	{
	    $this->createTable('{{config}}', array(
	        'key' => 'VARCHAR(100) NOT NULL PRIMARY KEY',
            'value' => 'text',
        ), 'ENGINE=INNODB DEFAULT CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('{{config}}');
	}
}