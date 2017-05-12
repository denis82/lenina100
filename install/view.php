<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Установка</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container" style="margin: 0;">
                        <div class="nav-collapse">
                            <ul class="nav pull-right">
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">

                </div>
                <div class="span10">
                    <div class="page-header">
                        <h1>Установка базы данных</h1>
                    </div>
                    <?php if($result['success']): ?>
                    <div class="clearfix">
                        <?php echo $result['success']; ?>
                    </div>                        
                    <?php else: ?>
                    <form action="/install/index.php" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        <fieldset>
                            <?php if($result['message']): ?>
                            <div class="clearfix">
                                <?php echo $result['message']; ?>
                            </div>                                
                            <?php elseif($result['errors']): ?>
                            <div class="clearfix">
                                <?php echo "Необходимо заполнить поля: ". implode(', ', $result['errors']); ?>
                            </div>                                
                            <?php endif; ?>
                            <?php foreach($fields as $field=>$params): ?>
                            <div class="control-group">
                                <label class="control-label" for="<?php echo $field; ?>">
                                    <?php echo $params['label']; ?>
                                </label>
                                <div class="controls">
                                    <input name="Install[<?php echo $field; ?>]" id="<?php echo $field; ?>"
                                    value="<?php echo $params['value']; ?>">    
                                </div>
                            </div>                                
                            <?php endforeach; ?>
                            <h2>Обновление базы данных</h2>
                            <div class="control-group">
                                <label class="control-label" for="dbfile">Файл MySQL</label>
                                <div class="controls">
                                    <input type="file" name="Install[file]" id="dbfile">
                                </div>
                                <label class="control-label" for="dbdelete">Очистить</label>
                                <div class="controls">
                                    <input type="checkbox" name="Install[delete]" id="dbdelete" />
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="success" class="btn btn-primary">Отпарвить</button>        
                            </div>
                        </fieldset>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
