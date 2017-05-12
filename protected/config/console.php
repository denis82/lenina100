<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Console Application',
    'commandMap' => array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
            'migrationPath'=>'application.migrations',
            'migrationTable'=>'{{migrations}}',
            'connectionID' => 'db',
        ),
        'migrate' => require dirname(__FILE__).'/_migrate.php',
        'cron' => array(
            'class' => 'ext.W3CronCommand.W3CronCommand',
        ),
    ),
    'components' => array(
        'db' => require dirname(__FILE__).'/_db.php',
        'config' => array(
            'class' => 'ext.config.EConfig',
            'configTableName' => '{{config}}',
            'autoCreateConfigTable' => true,
            'strictMode' => false,
        ),
        'mailManager' => array(
            'class' => 'ext.mailManager.MailManager',
        ),
    ),
);
