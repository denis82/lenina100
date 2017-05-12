<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="ru" class="no-js ie7 index"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="ru" class="no-js ie8 index"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="ru" class="no-js ie9 index"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html dir="ltr" lang="ru" class="no-js index"><!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <?php
            $cs = Yii::app()->clientScript;
            $cs->registerCssFile("/css/layout_admin.css")
                ->registerCssFile("/css/bootstrap.min.css");
        ?>
    </head>
    <body class="login">
        <?php echo $content; ?>
    </body>
</html>
