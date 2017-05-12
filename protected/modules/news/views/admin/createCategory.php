<?php
$this->clips['title'] = 'Создание раздела';

?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'category',
    'type' => 'horizontal',
)); ?>

    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span8')); ?>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(BHtml::icon('ok white').' Сохранить', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
        <?php echo CHtml::link(BHtml::icon('ban-circle').' Отмена',
                   array('index'),
                   array('title'=>'Отмена', 'class'=>'btn small')); ?>
    </div>

<?php $this->endWidget(); ?>
