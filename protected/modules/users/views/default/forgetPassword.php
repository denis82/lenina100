<?php $this->pageTitle = 'Восстановление пароля'; ?>
<div class="row">
    <div class="span15">
    <?php echo BHtml::flash(); ?>
    <h2><?php echo $this->pageTitle; ?></h2>
    <?php if (!Yii::app()->user->hasFlash('recovery')): ?>
        <?php echo CHtml::beginForm(); ?>
            <div class="clearfix">
                <?php echo CHtml::activeLabelEx($recoveryForm, 'email'); ?>
                <?php echo CHtml::activeTextField($recoveryForm, 'email'); ?>
            </div>
            <div class="form-actions">
                <?php echo CHtml::submitButton('Отправить', array('class' => 'btn-primary')); ?>
            </div>
        <?php echo CHtml::endForm(); ?>
    <?php endif; ?>

    </div>

</div>