<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'role-form',
    'type' => 'horizontal',
));
?>
<fieldset>

    <?php echo $form->textFieldRow($model, 'id'); ?>
    <?php echo $form->textFieldRow($model, 'description'); ?>
    <?php echo $form->checkBoxListRow($model, 'children', $model->childrenOptions); ?>

    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Сохранить', array('class' => 'btn btn-primary', 'type' => 'success')); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
