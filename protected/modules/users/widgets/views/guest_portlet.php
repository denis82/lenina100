<?php /*
<?php echo CHtml::beginForm(array('/users/default/login'), 'post', array('class' => 'well')); ?>
    <h2>Вход</h2>

    <?php echo CHtml::activeLabelEx($form, 'email'); ?>
    <?php echo CHtml::activeTextField($form, 'email', array('class' => 'span11')); ?>

    <?php echo CHtml::activeLabelEx($form, 'password'); ?>
    <?php echo CHtml::activePasswordField($form, 'password', array('class' => 'span11')); ?>

    <?php echo CHtml::submitButton('Вход'); ?> 
<?php echo CHtml::endForm(); ?> */ ?>

<?php echo CHtml::link('Вход', array('/users/default/login')); ?>
