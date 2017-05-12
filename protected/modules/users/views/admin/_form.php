<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'users',
    'type' => 'horizontal',
)); ?>
    <fieldset>

        <?php echo $form->textFieldRow($model, 'email'); ?>
        <?php echo $form->textFieldRow($model, 'name'); ?>
        <?php echo $form->dropDownListRow($model, 'role', $model->getRoleOptions()); ?>

        <?php echo $form->passwordFieldRow($model, 'new_password'); ?>
        <?php echo $form->passwordFieldRow($model, 'new_password_repeat'); ?>
        <?php //echo $form->passwordFieldRow($model, 'password_repeat'); ?>

        <div class="form-actions">
            <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i>Сохранить', array('class'=>'btn btn-primary', 'type' => 'submit')); ?>
            <?php echo CHtml::link('Отмена', array('index'), array('title'=>'Отмена', 'class'=>'btn')); ?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>
