<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Дизайн-студия Три Цвета <http://3colors.ru>">
        <!-- Work with Google ChromeFrame -->
        <meta http-equiv="X-UA-Compatible" content="chrome=1">


        <!--[if lt IE 9]>
            <script src="http://html5shim.google.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <?php Yii::app()->clientScript->registerPackage('jquery'); ?>
        <?php Yii::app()->clientScript
                ->registerLinkTag('stylesheet/less', 'text/css', $this->assetsUrl . '/css/admin.less')
                ->registerScriptFile($this->assetsUrl . '/js/libs/less/less-1.1.3.min.js')
                ->registerScriptFile($this->assetsUrl  . '/js/colorbox/jquery.colorbox.js')
                ->registerCssFile($this->assetsUrl  . '/css/colorbox/colorbox.css');
        ?>
        <script type="text/javascript">
            $(function() {
                $('.colorbox').colorbox();
            })
            /*
            $(function() {
                $('.grid-view a.delete').live('click', function(event) {
                    event.stopPropagation();
                    event.preventDefault();

                    var url = $(this).attr('href');
                    $.post(url, {}, function() {
                        location.reload();
                    });
                });
            }); */
        </script>

    </head>
    <body>
        <?php $this->widget('EAdminMenuWidget'); ?>

        <div class="container-fluid">
            <div class="row-fluid">
                <?php //var_dump($this->getClips()->itemAt('sidebar'));?>
                <div class="span2">
                    <?php if (!preg_match('/^\s*(\&nbsp\;)?\s*$/', $this->getClips()->itemAt('sidebar'))): ?>
                    <div class="well sidebar">
                        <?php $this->renderClip('sidebar'); ?>
                    </div>
                    <?php else: echo '&nbsp;'; ?>
                    <?php endif; ?>
                </div>
                <div class="span10">
                    <?php

                    if (Yii::app()->user->checkAccess('pages.admin')) {
                        $homeLink = array('label' => 'Главная', 'url' => array('/pages/admin/index'));
                    } else {
                        $homeLink = array('label' => 'Главная', 'url' => '#');
                    }

                    $this->widget('ext.bootstrap.widgets.BootCrumb', array(
                        'homeLink' => array(
                            'label' => 'Главная',
                            'url' => array('/pages/admin/index'),
                        ),
                        'links' => $this->breadcrumbs,
                    )); ?>
                    <?php if ($this->getClips()->itemAt('title')):?>
						<div class="page-header">
							<h1><?php $this->renderClip('title'); ?></h1>
							<?php if ($this->clips['buttons']) {
								echo CHtml::tag('div', array('class'=>'right-header'),
									join('&nbsp;', $this->clips['buttons'])
								);
							} ?>
						</div>
					<?php endif; ?>
                    <?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>
                    <?php echo $content; ?>
                </div>
            </div> <!-- .row-fluid -->
        </div> <!-- .container-fluid -->

<?php /*
        <div class="container-fluid">
            <div class="sidebar">
                <?php //$this->widget('AdminMenuWidget'); ?>
            </div>
            <div class="content">
                <?php echo $content; ?>
            </div>
                </div> */ ?>
        <div class="container">
            <footer class="footer">
                <p>&copy; <?php echo date('Y'); ?> Дизайн-студия &laquo;<a target="_blank" href="http://www.3colors.ru">Три Цвета</a>&raquo;</p>
            </footer>
        </div>
    </body>
</html>
