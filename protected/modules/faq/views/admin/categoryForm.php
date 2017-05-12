<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'category',
    'type' => 'horizontal',
)); ?>
<fieldset>
	
    <?php echo $form->textFieldRow($model, 'title'); ?>
    <?php echo $form->textFieldRow($model, 'url'); ?>
    <?php echo $form->textFieldRow($model, 'weight'); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton('Сохранить',
                                           array('class'=>'btn btn-primary')); ?>
		<?php echo CHtml::link('Отмена', 
                       array('index'),
                       array('title'=>'Отмена', 'class'=>'btn small')); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
