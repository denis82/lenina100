<div class="block_form message">
    <?php if(!Yii::app()->user->hasFlash('faq')): ?>
        <h3>Задать вопрос</h3>
        <?php echo CHtml::beginForm('', 'post', array('id'=>'faq_left')); ?>
        <div class="row">
            <?php echo CHtml::activeLabelEx($model, 'name_q'); ?>
            <?php echo CHtml::activeTextField($model, 'name_q', array('class'=>'placeholder')); ?>
        </div>
        <div class="row">
            <?php echo CHtml::activeLabelEx($model, 'email'); ?>
            <?php echo CHtml::activeTextField($model, 'email', array('class'=>'placeholder')); ?>
        </div>
        <div class="row">
            <?php echo CHtml::activeDropDownList($model, 'city', 
                CHtml::listData(PageCategory::cities(), 'content_title', 'content_title')); ?>         
        </div> 
        <div class="row textarea">
            <?php echo CHtml::activeLabelEx($model, 'quest'); ?>
            <?php echo CHtml::activeTextArea($model, 'quest', array('cols'=>30, 'rows'=>10, 'class'=>'placeholder')); ?>
        </div>
        <div class="row buttons">
                <?php echo CHtml::submitButton('Задать вопрос'); ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    <?php else: ?>
        <p><?php echo Yii::app()->user->getFlash('faq'); ?></p>
    <?php endif; ?>
</div>