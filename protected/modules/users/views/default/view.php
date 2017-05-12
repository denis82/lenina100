<?php if (Yii::app()->user->model !== null && Yii::app()->user->model->id == $model->id): ?>
    
    <div class="page-header">
        <h1>Ваш профиль</h1>
    </div>

    <?php if (Yii::app()->user->hasFlash('users.default.view')): ?>
        <?php echo CHtml::tag('p', array(), Yii::app()->user->getFlash('users.default.view')); ?>
    <?php endif; ?>

    <?php echo CHtml::beginForm(); ?>
        <fieldset>
            <div class="control-group">
                <?php echo CHtml::activeLabelEx($model, 'email'); ?>
                <div class="control">
                    <?php echo CHtml::activeTextField($model, 'email', array('class' => 'span4')); ?>
                    <?php echo CHtml::error($model, 'email'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabelEx($model, 'name'); ?>
                <div class="control">
                    <?php echo CHtml::activeTextField($model, 'name', array('class' => 'span4')); ?>
                    <?php echo CHtml::error($model, 'name'); ?>
                </div>
            </div>
            <div class="form-actions">
                <?php echo CHtml::submitButton('Сохранить'); ?>
            </div>
        </fieldset>
    <?php echo CHtml::endForm(); ?>

<?php else: ?>

    <h1>Пользователь</h1>

    <?php echo $model->name; ?>


<?php endif; ?>