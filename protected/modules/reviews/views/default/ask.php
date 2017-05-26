<?php
$this->clips['title'] = 'Задать вопрос';
?>

<?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($model); ?>
    <fieldset>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'name_review'); ?>
            <div class="control">
                <?php echo CHtml::activeTextField($model, 'name_review', array('title'=>'Имя')); ?>
                <?php echo CHtml::error($model, 'name_review'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'reviews'); ?>
            <div class="control">
                <?php echo CHtml::activeTextArea($model, 'reviews', array('title'=>'Вопрос')); ?>
                <?php echo CHtml::error($model, 'reviews'); ?>
            </div>
        </div>

        <?php if(extension_loaded('gd') && Yii::app()->user->isGuest): ?>
            <div class="control-group">
                <div class="captcha">
                    <?php $this->widget('CCaptcha',array(
                        'buttonLabel'=>'',
                        'clickableImage'=>true
                    )); ?>
                </div>
                <?php echo CHtml::activeLabel($model, 'verifyCode'); ?>
                <div class="control">
                    <?php echo CHtml::activeTextField($model, 'verifyCode',array('title'=>'Код')); ?>
                    <?php echo CHtml::error($model, 'error'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-actions">
            <?php echo CHtml::submitButton('Задать вопрос',array('class'=>'btn btn-primary')); ?>
        </div>
    </fieldset>
<?php echo CHtml::endForm(); ?>

