<!doctype html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $this->pageTitle; ?></title>
    </head>

    <body>
        <?php $this->widget('pages.components.Menu'); ?>
        <?php echo $content; ?>
    </body>
</html>
