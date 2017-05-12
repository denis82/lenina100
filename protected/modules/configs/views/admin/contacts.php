<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'config',
    'type' => 'vertical',
)); ?>

    <?php echo $form->textFieldRow($configForm, 'adminEmail', array('class' => 'span10', 'hint' => 'Один или несколько разделенный пробелом или запятой')); ?>

        <h2>Обратная связь</h2>
        <div class="clearfix">
            <?php echo $form->labelEx($configForm, 'contactEmailTemplate'); ?>
            <div class="input">
                <?php echo $form->textArea($configForm, 'contactEmailTemplate', array('class' => 'span10', 'rows' => '10')); ?>
            </div>
        </div>
        <div class="clearfix">
            <?php $this->widget('bootstrap.widgets.BootDetailView', array(
                'data'=>array('id'=>1, 'name' => '{{name}}', 'phone' => '{{phone}}', 'email' => '{{email}}', 'message' => '{{message}}'),
                'attributes'=>array(
                    array('name' => 'name', 'label' => 'Имя'),
					array('name' => 'phone', 'label' => 'Телефон'),
                    array('name' => 'email', 'label' => 'E-mail'),
                    array('name' => 'message', 'label' => 'Сообщение'),
                ),
            )); ?>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($configForm, 'messageEmailTemplate'); ?>
            <div class="input">
                <?php echo $form->textArea($configForm, 'messageEmailTemplate', array('class' => 'span10', 'rows' => '10')); ?>
            </div>
        </div>
        <div class="clearfix">
            <?php $this->widget('bootstrap.widgets.BootDetailView', array(
                'data'=>array('id'=>1, 'name' => '{{name}}', 'phone' => '{{phone}}'),
                'attributes'=>array(
                    array('name' => 'name', 'label' => 'Имя'),
                    array('name' => 'phone', 'label' => 'Телефон'),
                ),
            )); ?>
        </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Сохранить', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    </div>
<?php $this->endWidget(); ?>
