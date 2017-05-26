<?php $this->beginClip('sidebar'); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootMenu', array(
        'type' => 'list',
        'items'=>$this->menu,
    )); ?>
<?php $this->endClip(); ?>

<?php echo $content; ?>

