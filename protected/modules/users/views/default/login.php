<?php $this->clips['title'] = 'Вход'; ?>

<div class="row">
    <div class="span15">
        <?php echo BHtml::flash(); ?>
        <h2><?php echo $this->pageTitle; ?></h2>
        <?php echo CHtml::beginForm(); ?>
            <div class="clearfix">
                <?php echo CHtml::activeLabelEx($loginForm, 'email'); ?>
                <?php echo CHtml::activeTextField($loginForm, 'email', array('class'=>'span4')); ?>
            </div>
            <div class="clearfix">
                <?php echo CHtml::activeLabelEx($loginForm, 'password'); ?>
                <?php echo CHtml::activePasswordField($loginForm, 'password', array('class'=>'span4')); ?>
            </div>
            <div class="clearfix">
                <?php echo CHtml::activeLabelEx($loginForm, 'notRememberMe'); ?>
                <?php echo CHtml::activeCheckBox($loginForm, 'notRememberMe'); ?>
            </div>
            <?php //echo EHtml::row('text', $loginForm, 'email'); ?>
            <?php //echo EHtml::row('password', $loginForm, 'password'); ?>
            <?php //echo EHtml::row('checkbox', $loginForm, 'notRememberMe'); ?>

            <div class="form-actions">
                <?php echo CHtml::submitButton('Вход', array('class' => 'btn-primary')); ?>
            </div>
        <?php echo CHtml::endForm(); ?>
    </div>
    <div class="span15">

        <br />
        <?php echo CHtml::link('Забыли пароль?', array('/users/default/forgetPassword')); ?>

        <br />
        <?php echo CHtml::link('Зарегистрироваться', array('/users/default/registration')); ?>
    </div>
</div>
