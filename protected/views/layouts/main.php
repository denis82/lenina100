<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->pageTitle; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="/bootstrap/images/favicon.ico">
        <link rel="apple-touch-icon" href="/bootstrap/images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/bootstrap/images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/bootstrap/images/apple-touch-icon-114x114.png">
        <?php  $assetManager = Yii::app() -> assetManager;
        $baseUrl = $assetManager -> publish(Yii::getPathOfAlias('webroot.protected.extensions.bootstrap.assets')); ?>
        <?php Yii::app()->clientScript->registerPackage('jquery'); ?>
        <?php Yii::app()->clientScript
                ->registerCssFile($baseUrl . '/css/bootstrap.css')
                ->registerCssFile($baseUrl . '/css/bootstrap-responsive.css')
                ->registerScriptFile($baseUrl.'/js/bootstrap.min.js')
        ?>
    </head>

    <body>

        <div class="container-fluid">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container" style="margin: 0;">
                        <div class="nav-collapse">
                            <?php $this->widget('pages.components.Menu');  ?>
                            <?php if (Yii::app()->user->isGuest): ?>
                                <ul class="nav pull-right">
                                    <li><?php echo CHtml::link('Вход', array('/users/default/login')); ?></li>
                                </ul>
                            <?php else: ?>
                                <ul class="nav pull-right">
                                    <?php $user = Yii::app()->user->model;
                                          $access = AuthItemForm::getById($user->role);
                                    ?>
                                    <?php if(($access && $access->children) || Yii::app()->user->checkAccess('root')): ?>
                                        <li><?php echo CHtml::link('Управление',
                                            empty($access->children) ? '/admin/'  :
                                            array(preg_replace('/^(\S+)(\.admin)/i', '/$1/admin/index', $access->children[0]))); ?>
                                        </li>
                                    <?php endif; ?>
                                    <li><?php echo CHtml::link('Профиль', array('/profile')); ?></li>
                                    <li><?php echo CHtml::link('Выход', array('/users/default/logout')); ?></li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">
                    <?php $this->widget('pages.components.Menu'); ?>
                    <?php $this->widget('shop.widgets.CartWidget'); ?>
                    <?php $this->widget('news.components.RecentNewsWidget'); ?>
                    <?php $this->widget('vote.widgets.WVote'); ?>
                </div>
                <div class="span10">
                    <?php $this->widget('Breadcrumbs', array(
                        'links' => $this->breadcrumbs,
                    )); ?>

                    <?php if (!empty($this->clips['title'])): ?>
                    <div class="page-header">
                        <h1><?php echo $this->renderClip('title'); ?></h1>
                    </div>
                    <?php endif; ?>

                    <?php $this->widget('FlashMessages'); ?>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </body>
</html>
