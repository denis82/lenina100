<div class="block-name">
	Оставить свой отзыв
</div>

<div class="side-form">
    <?php if(!Yii::app()->user->hasFlash('reviews')): ?>
        <?php echo CHtml::beginForm(); ?>
            <label>
                <?php echo CHtml::activeLabelEx($model, 'name_review'); ?>
                <?php echo CHtml::activeTextField($model, 'name_review', array('title'=>'Имя', 'type'=>'text', 'class'=>'text')); ?>
            </label>
            <label>
                <?php echo CHtml::activeLabelEx($model, 'reviews'); ?>
                <?php echo CHtml::activeTextArea($model, 'reviews', array('title'=>'Отзыв',)); ?>
            </label>
            
            <div class="reviews__inner">
		    <?php echo CHtml::activeCheckBox($model, 'agree') ?>
		
		    <?php echo CHtml::activeLabelEx($model, 'agree'); ?>
		
            </div>
            <div class="g-recaptcha" data-sitekey="6LfA_yIUAAAAAMJuY_--QUCyH8qsGg6IDio_swcI"></div>
            <div class="row">
                
            <?php     echo CHtml::htmlButton('Оставить отзыв',
						array('type' => 'submit',
							'title' => 'Оставить отзыв',
							'class' => 'center mini',
						)
					); 
            ?>
				
			</div>
        <?php echo CHtml::endForm(); ?>
    <?php else: ?>
        <p><?php echo Yii::app()->user->getFlash('reviews'); ?></p>
    <?php endif; ?>
</div>		