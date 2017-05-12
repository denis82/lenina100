<div class="block-name">
	Задайте свой вопрос
</div>

<div class="side-form">
    <?php if(!Yii::app()->user->hasFlash('faq')): ?>
        <?php echo CHtml::beginForm(); ?>
            <label>
                <?php echo CHtml::activeLabelEx($model, 'name_q'); ?>
                <?php echo CHtml::activeTextField($model, 'name_q', array('title'=>'Имя', 'type'=>'text', 'class'=>'text')); ?>
            </label>
            <label>
                <?php echo CHtml::activeLabelEx($model, 'email'); ?>
                <?php echo CHtml::activeTextField($model, 'email', array('title'=>'Ваш e-mail', 'type'=>'text', 'class'=>'text')); ?>
            </label>
            <label>
                <?php echo CHtml::activeLabelEx($model, 'quest'); ?>
                <?php echo CHtml::activeTextArea($model, 'quest', array('title'=>'Вопрос',)); ?>
            </label>
            <div class="g-recaptcha" data-sitekey="6LcdMhMUAAAAAKgxgM9XJNQdoz6eT-9yyhDICAao"></div>
            <div class="row">
                
            <?php     echo CHtml::htmlButton('Задать вопрос',
						array('type' => 'submit',
							'title' => 'Задать вопрос',
							'class' => 'center mini',
						)
					); 
            ?>
				
			</div>
        <?php echo CHtml::endForm(); ?>
    <?php else: ?>
        <p><?php echo Yii::app()->user->getFlash('faq'); ?></p>
    <?php endif; ?>
</div>
