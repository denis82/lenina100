<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return  array(
    'class' => 'ext.migrate-command.EMigrateCommand',
    'migrationPath' => 'application.migrations',
    'migrationTable' => '{{migrations}}',
    'applicationModuleName' => 'core',
    /***  MODULES  ***/
    'modulePaths' => array(
        'users'    => 'application.modules.users.migrations',
        'pages'    => 'application.modules.pages.migrations',
        'news'     => 'application.modules.news.migrations',
        'faq'      => 'application.modules.faq.migrations',
        'vote'     => 'application.modules.vote.migrations',
        'gallery'  => 'application.modules.gallery.migrations',
        'catalog'  => 'application.modules.catalog.migrations',
        'shop'     => 'application.modules.shop.migrations',
        'configs'  => 'application.modules.configs.migrations',
    ),
    /***  DISABLED MODULES  ***/
    'disabledModules' => array(
        //'pages',
        //'news',
        //'faq',
        //'vote',
        //'gallery',
        //'catalog',
        //'shop',
    ),
    'connectionID' => 'db',
);
