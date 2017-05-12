<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'config',
    'type' => 'vertical',
)); ?>

        <h2>Вопросы и ответы</h2>
        <div class="clearfix">
            <?php echo $form->labelEx($configForm, 'faqUserEmailTemplate'); ?>
            <div class="input">
                <?php echo $form->textArea($configForm, 'faqUserEmailTemplate', array('class' => 'span10', 'rows' => '10')); ?>
            </div>
        </div>
        <div class="clearfix">
            <?php $this->widget('bootstrap.widgets.BootDetailView', array(
                'data'=>array('id'=>1, 'name_q' => '{{name_q}}', 'email' => '{{email}}', 
                    'quest' => '{{quest}}', 'name_a' => '{{name_a}}', 'answer' => '{{answer}}'),
                'attributes'=>array(
                    array('name' => 'name_q', 'label' => 'Ваше имя'),
                    array('name' => 'email', 'label' => 'Телефон или E-mail'),
                    array('name' => 'quest', 'label' => 'Ваш вопрос'),
                    array('name' => 'name_a', 'label' => 'Отвечает'),
                    array('name' => 'answer', 'label' => 'Ответ'),
                ),
            )); ?>
        </div>

        <div class="clearfix">
            <?php echo $form->labelEx($configForm, 'faqAdminEmailTemplate'); ?>
            <div class="input">
                <?php echo $form->textArea($configForm, 'faqAdminEmailTemplate', array('class' => 'span10', 'rows' => '10')); ?>
            </div>
        </div>
        <div class="clearfix">
            <?php $this->widget('bootstrap.widgets.BootDetailView', array(
                'data'=>array('id'=>1, 'name_q' => '{{name_q}}', 'email' => '{{email}}','quest' => '{{quest}}'),
                'attributes'=>array(
                    array('name' => 'name_q', 'label' => 'Имя пользователя'),
                    array('name' => 'email', 'label' => 'Телефон или E-mail'),
                    array('name' => 'quest', 'label' => 'Вопрос'),
                ),
            )); ?>
        </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Сохранить', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    </div>
<?php $this->endWidget(); ?>
