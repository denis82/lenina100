<?php $this->beginClip('title'); ?>
Регистрация
<?php $this->endClip(); ?>

<?php if (Yii::app()->user->hasFlash('registration')): ?>
    <p><?php echo Yii::app()->user->getFlash('registration'); ?>
<?php endif; ?>

<?php echo CHtml::errorSummary($model); ?>
<?php echo CHtml::beginForm(array('/users/default/registration'), 'post', array('class' => 'form-horizontal')); ?>
    <fieldset>
        <legend>Заполните форму</legend>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'email'); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'email'); ?>
                <?php echo CHtml::error($model, 'email'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'name'); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'name'); ?>
                <?php echo CHtml::error($model, 'name'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'password'); ?>
            <div class="controls">
                <?php echo CHtml::activePasswordField($model, 'password'); ?>
                <?php echo CHtml::error($model, 'password'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'password_repeat'); ?>
            <div class="controls">
                <?php echo CHtml::activePasswordField($model, 'password_repeat'); ?>
                <?php echo CHtml::error($model, 'password_repeat'); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton('Зарегистрироваться', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
        </div>
    </fieldset>
<?php echo CHtml::endForm(); ?>

