<div class="form">
<?php echo CHtml::beginForm('','post',array('class'=>'create-dir-form')); ?>
    <div class="row">
        <?php echo CHtml::label("Название директории", 'dirName'); ?>
        <?php echo CHtml::textField('dirName', ''); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Создать'); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>