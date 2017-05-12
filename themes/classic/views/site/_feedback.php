<?php if(Yii::app()->user->hasFlash('contact')): ?>
    <p><?php echo Yii::app()->user->getFlash('contact'); ?></p>
<?php else: ?>
    <div class="block-name">Отправить сообщение</div>
    <div class="side-form">
    <?php echo CHtml::beginForm(); ?>
        <label>
            <?php echo CHtml::activeLabel($model, 'name'); ?>
            <?php echo CHtml::activeTextField($model, 'name', array('class'=>'text')); ?>
        </label>
        <label>
            <?php echo CHtml::activeLabel($model, 'email'); ?>
            <?php echo CHtml::activeTextField($model, 'email', array('class'=>'text')); ?>
        </label>
        <label>
            <?php echo CHtml::activeLabel($model, 'message'); ?>
            <?php echo CHtml::activeTextArea($model, 'message'); ?>
        </label>

        <div class="row">
            <div class="mybutton">
                <?php echo CHtml::htmlButton('Отправить сообщение',
                    array('type' => 'submit',
                          'title' => 'Отправить сообщение',
						  'class' => 'center mini')); ?>
            </div>
        </div>
    <?php echo CHtml::endForm(); ?>
    </div>

<?php endif; ?> 
