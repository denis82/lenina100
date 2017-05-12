<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'config',
    'type' => 'vertical',
)); ?>

    <?php echo $form->textFieldRow($configForm, 'adminEmail', array('class' => 'span10', 'hint' => 'Один или несколько разделенный пробелом или запятой')); ?>

        <h2>Запись на приём к специалисту</h2>
        <div class="clearfix">
            <?php echo $form->labelEx($configForm, 'orderEmailTemplate'); ?>
            <div class="input">
                <?php echo $form->textArea($configForm, 'orderEmailTemplate', array('class' => 'span10', 'rows' => '10')); ?>
            </div>
        </div>
        <div class="clearfix">
            <?php $this->widget('bootstrap.widgets.BootDetailView', array(
                'data'=>array('id'=>1, 
					'name' => '{{name}}', 
					'sex' => '{{sex}}', 
					'born_date' => '{{born_date}}', 
					'phone' => '{{phone}}', 
					'service' => '{{service}}', 
					'date' => '{{date}}', 
					'comment' => '{{comment}}', 
					'sub' => '{{sub}}'
				),
                'attributes'=>array(
                    array('name' => 'name', 'label' => 'Имя'),
					array('name' => 'sex', 'label' => 'Пол'),
					array('name' => 'born_date', 'label' => 'Дата рождения'),
					array('name' => 'phone', 'label' => 'Телефон'),
					array('name' => 'service', 'label' => 'Направление'),
					array('name' => 'date', 'label' => 'Желаемое время'),
                    array('name' => 'comment', 'label' => 'Комментарии'),
                    array('name' => 'sub', 'label' => 'Разрешение обработки'),
                ),
            )); ?>
        </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Сохранить', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    </div>
<?php $this->endWidget(); ?>
