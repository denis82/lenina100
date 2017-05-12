<?php

// Конфигурация URL менеджера
return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'useStrictParsing' => true,
    'rules' => array(

        /* ADMIN */
        '/admin/<_m>/<_a>' => '<_m>/admin/<_a>',
        '/admin' => 'pages/admin/index',

        /* SITE */
        '/sitemap'=>'site/siteMap',
        '/sitemap.xml'=>'site/siteMapXml',
				'/message' => 'site/message',
        '/message/<view:\w+>' => 'site/message',
				'/appointment' => 'site/appointment',
        '/appointment/<view:\w+>' => 'site/appointment',
				'/expert_box/<id:\d+>' => 'expert/default/expertBox',
        //'/expert_box/<view:\w+>' => 'site/expert_box/<view:\w+>',
        '/contacts' => 'site/contacts',
        '/errors' => 'site/manualError',
        '/errors/<id:\d+>' => 'site/manualError',
				'/map'=>'/site/map',

        /* USERS */
        '/registration' => 'users/default/registration',
        '/login' => 'users/default/login',
        '/logout' => 'users/default/logout',
        '/profile' => 'users/default/view',
        '/users/<_c>/<_a>/*' => 'users/<_c>/<_a>',
        
        /* NEWS */
        '/news' => 'news/default/index',
        '/news/<id:\d+>' => 'news/default/view',
        '/news/<_c>/<_a>/*' => 'news/<_c>/<_a>',
		
		/* INFO */
        '/info' => 'info/default/index',
        '/info/<id:\d+>' => 'info/default/view',
        '/info/<_c>/<_a>/*' => 'info/<_c>/<_a>',

        /* FAQ */
        '/faq' => 'faq/default/index',
        '/faq/<category_url:\w+>' => 'faq/default/index',

        /* EXPERT */
        '/experts' => 'expert/default/index',
		'/experts/<url:\w+>' => 'expert/default/index',
        '/experts/<_c>/<_a>/*' => 'expert/<_c>/<_a>',
        '/experts/<_c>' => 'expert/<_c>',
		
		/* Banner */
        '/banner/<_c>/<_a>/*' => 'banner/<_c>/<_a>',
        '/banner/<_c>' => 'banner/<_c>',
        '/banner' => 'banner',

        /* ALL */
        //'/<_m>/<_c>/<_a>'=>'<_m>/<_c>/<_a>',
        /* PAGES */
        '/<route:\S+>' => 'pages/default/view',
        '/' => 'pages/default/view',
    ),
);
