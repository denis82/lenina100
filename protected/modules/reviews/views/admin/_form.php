<?php echo CHtml::beginForm(array(),'post',array('id' => 'faqForm', 'class'=>'form-stacked')); ?>
<fieldset>
        <legend><?php echo $this->clips['content_title']; ?></legend>

		<?php //echo BHtml::flash(); ?>

		<?php echo CHtml::errorSummary($model); ?>

		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'name_review'); ?>
			<div class="input">
				<?php echo CHtml::activeTextField($model, 'name_review',array('class'=>'span9')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'reviews'); ?>
			<div class="input">
				<?php echo CHtml::activeTextArea($model, 'reviews', array('rows'=>5, 'class'=>'span9')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'status'); ?>
			<div class="input">
				<?php echo CHtml::activeDropDownList($model, 'status', $model->statusOptions); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'visible'); ?>
			<div class="input">
				<?php echo CHtml::activeDropDownList($model, 'visible', $model->visibilityOptions); ?>
			</div>
		</div>
		<div class="actions">
			<p>Внимание! После присвоения статуса Отвечен - пользователь автоматически получит ответ на email.</p>
                        <?php echo CHtml::submitButton($update ? 'Сохранить' : 'Создать',
                                           array('class'=>'btn primary')); ?>
			<?php echo CHtml::link('Отмена',
                       array('index'),
                       array('title'=>'Отмена', 'class'=>'btn small')); ?>
		</div>
</fieldset>
<?php echo CHtml::endForm(); ?>