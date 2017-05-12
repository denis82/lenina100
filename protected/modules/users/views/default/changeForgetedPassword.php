<?php $this->pageTitle = 'Смена пароля'; ?>
<div class="row">
    <div class="span15">
        <?php echo BHtml::flash(); ?>
        <h2><?php echo $this->pageTitle; ?></h2>        
        <?php echo CHtml::beginForm(); ?>
            <div class="clearfix">
                <?php echo CHtml::activeLabelEx($changePasswordForm, 'password'); ?>
                <?php echo CHtml::activeTextField($changePasswordForm, 'password'); ?>
            </div>
            <div class="clearfix">
                <?php echo CHtml::activeLabelEx($changePasswordForm, 'password_repeat'); ?>
                <?php echo CHtml::activeTextField($changePasswordForm, 'password_repeat'); ?>
            </div>
            <div class="form-actions">
                <?php echo CHtml::submitButton('Отправить', array('class' => 'btn-primary')); ?>
            </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
