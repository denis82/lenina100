<?php

class m110530_183150_create_pages_table extends CDbMigration {

    public function up() {
        $this->createTable('{{pages}}', array(
            'id' => 'pk',

            'lft' => 'integer NOT NULL',
            'rgt' => 'integer NOT NULL',
            'level' => 'integer NOT NULL',

            'type' => 'boolean DEFAULT 0',
            'create_time' => 'integer NOT NULL',
            'name' => 'string NOT NULL',
            'url' => 'string NOT NULL',
            'param' => 'string NOT NULL',
            'layout' => 'string DEFAULT NULL',
            'content' => 'text NOT NULL',
            'is_visible' => 'boolean DEFAULT 0',
            'content_title' => 'text',
            'page_title' => 'text NOT NULL',
            'label' => 'text NOT NULL',
            'keywords' => 'text',
            'description' => 'text',

        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('rgt', '{{pages}}', 'rgt');
        $this->createIndex('lft', '{{pages}}', 'lft');
        $this->createIndex('level', '{{pages}}', 'level');

        $this->insert('{{pages}}', array(
            'id' => '1',
            'lft' => '1',
            'rgt' => '2',
            'level' => '1',
            'type' => '0',
            'create_time' => time(),
            'name' => '/',
            'url' => '/',
            'param' => '',
            'layout' => 'main',
            'content' => '<p>Главная страница</p>',
            'is_visible' => '1',
            'content_title' => 'Главная страница',
            'page_title' => 'Главная страница',
            'label' => 'Главная страница',
            'keywords' => 'Главная страница',
            'description' => 'Главная страница'
        ));
    }

    public function down() {
        $this->dropTable('{{pages}}');
    }
}
