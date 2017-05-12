<?php echo CHtml::beginForm(array(),'post',array('id' => 'faqForm', 'class'=>'form-stacked')); ?>
<fieldset>
        <legend><?php echo $this->clips['content_title']; ?></legend>

		<?php //echo BHtml::flash(); ?>

		<?php echo CHtml::errorSummary($model); ?>

		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'name_q'); ?>
			<div class="input">
				<?php echo CHtml::activeTextField($model, 'name_q',array('class'=>'span9')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'quest'); ?>
			<div class="input">
				<?php echo CHtml::activeTextArea($model, 'quest', array('rows'=>5, 'class'=>'span9')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'name_a'); ?>
			<div class="input">
				<?php echo CHtml::activeDropDownList($model, 'name_a', CHtml::listData(ExpertItem::getExpert(), 'id', 'name')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'answer'); ?>
			<div class="input">
				<?php echo CHtml::activeTextArea($model, 'answer', array('rows'=>5, 'class'=>'span9')); ?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo CHtml::activeLabelEx($model, 'category_id'); ?>
			<div class="input">
				<?php echo CHtml::activeDropDownList($model, 'category_id', CHtml::listData(FaqCategory::getCategoryOptions(), 'id', 'title'), array('empty'=>array(0=>'Без раздела'))); ?>
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