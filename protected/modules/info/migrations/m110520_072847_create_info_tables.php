<?php

class m110520_072847_create_info_tables extends CDbMigration
{
	public function up()
	{
	    $this->createTable('{{info_item}}', array(
	        'id' => 'pk',
	        'category_id' => 'integer NOT NULL DEFAULT 1',
            'author_id' => 'integer UNSIGNED NOT NULL',

	        'create_time' => 'integer NOT NULL',
	        'update_time' => 'integer NOT NULL',

	        'title' => 'string NOT NULL',
	        'annotation' => 'text NOT NULL',
	        'content' => 'text NOT NULL',

            'visible_in_rss' => 'boolean NOT NULL DEFAULT 0',
            'status' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',

            // При истечении времени новости помещаются в архив.
            'expire_time' => 'integer not null',

            'logo_url' => 'string not null default \'\'',

	    ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('{{info_category}}', array(
	        'id' => 'pk',
	        'title' => 'string NOT NULL',
	        'url' => 'string NOT NULL',
	    ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->insert('{{info_category}}', array(
            'title' => 'Общая',
            'url' => 'common',
        ));
	}

	public function down()
	{
        $this->dropTable('{{info_category}}');
		$this->dropTable('{{info_item}}');
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

