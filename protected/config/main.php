<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    /***  NAME OF APPLICATION  ***/
    'name' => 'РКВД',
    // preloading 'log' & 'user' component
    'preload' => array('log','user'),

    'charset' => 'UTF-8',
    'sourceLanguage' => 'ru',
    'language' => 'ru',

    /***  THEME  ***/
    'theme' => 'classic',

    /***  IMPORT  ***/
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.helpers.*',
        'application.widgets.*',
        'application.modules.users.models.*',

        // extensions
        'ext.admin.*',
        'ext.EOAuth.*',
        'ext.EOAuth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.*',
        'ext.eauth.services.*',
        'ext.simpleWorkflow.*',
        'ext.yiiext.behaviors.model.trees.NestedSetBehavior',
    ),

    /***  MODULES  ***/
    'modules' => array(
        'pages',
        'news',
        'faq',
        'expert',
	'banner',
        'users',
        'filemanager',
        'configs',
	'info',
	'reviews',
    ),
    
    //gzip
    /*'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
    'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),*/

    /***  APPLICATION COMPONENTS  ***/
    'components' => array(
        //security
        /*'request'=>array(
            'enableCookieValidation'=>true,
            'enableCsrfValidation'=>true,
        ),*/
        // css-js minify
       'clientScript' => array(
          'class' => 'ext.minify.EClientScript',
          'combineScriptFiles' => false, 
          'combineCssFiles' => false, 
          'optimizeCssFiles' => true,  // @since: 1.1
          'optimizeScriptFiles' => true,   // @since: 1.1
        ),
        // Пользователь
        'user' => array(
            'class' => 'users.components.WebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array('/users/default/login'),
        ),
        // Управление аутентификацией
        'authManager' => array(
            'class' => 'users.components.PhpAuthManager',
            'authFile' => dirname(__FILE__) . '/../modules/users/components/auth.php',
            'defaultRoles' => array('guest'),
        ),
        // Аутентификация по OpenID (необходимо для eauth)
        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),
        // Аутентификация через соц.сервисы
        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true,
            'services' => array(
                'google' => array(
                    'class' => 'GoogleOpenIDService',
                ),
                'yandex' => array(
                    'class' => 'YandexOpenIDService',
                ),
            ),
        ),
        // Менеджер публичных ресурсов
        'assetManager' => array(
            'class' => 'CAssetManager',
            'linkAssets' => true
        ),
        // Кэширование
        'cache' => array(
            'class' => 'CFileCache',
        ),
        // Url менджер
        'urlManager' => require dirname(__FILE__) . '/_urles.php',
        // Обработчик ошибок
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'request'=>array(
            // защита от CSRF
            //'enableCsrfValidation'=>true,
            // проверка cookie
            // 'enableCookieValidation'=>true,
        ),
        // Журналирование
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                /*array(
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'enabled'=>defined('DEVELOPMENT') && DEVELOPMENT,
                ),*/
                array(
                    'class' => 'CWebLogRoute',
                    'categories' => 'application',
                    'showInFireBug' => true
                ),
            ),
        ),
        // Дополнительны компоненты
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD',
        ),
        // Работа с файлами
        'file' => array(
            'class' => 'application.extensions.file.CFile'
        ),
        // Конфигурация приложения в БД
        'config' => array(
            'class' => 'application.modules.configs.models.EConfig',
            'configTableName' => '{{config}}',
            'autoCreateConfigTable' => true,
            'strictMode' => false,
        ),
        // Отправка почты
        'mailer' => array(
            'class' => 'ext.mailer.EMailer',
        ),
        // Работаем с почтой через этот компонент
        'mailManager' => array(
            'class' => 'ext.mailManager.MailManager',
        ),
        // Управление темами
        'themeManager' => array(
            //'class' => 'ThemeManager',
        ),
        // БД
        'db' => require dirname(__FILE__).'/_db.php',
        // Для магазина
        'shoppingCart' => array(
            'class' => 'ext.shoppingCart.EShoppingCart',
        ),

        'identityMap' => array(
            'class' => 'IdentityMap',
        ),

        'swSource' => array(
            'class' => 'application.extensions.simpleWorkflow.SWPhpWorkflowSource',
        ),
    ),

    /***  PARAMS  ***/
    'params' => array(
        'adminEmail' => array('3@3colors.ru'),
    ),
);
