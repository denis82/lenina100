<?php $this->beginContent('//layouts/main'); ?>
	
	<?php $class = ($this->clips['is_main_news']) ? 'main' : ''; ?>
	<div class="<?php echo $class; ?>" >
		<?php echo CHtml::tag('h1', array(), $this->clips['content_title']); ?>
		<div class="promotion">
			<?php echo $content; ?>
		</div>
	</div>

<div class="sidebar">
	<div class="block-questions shadow">
		<?php $this->widget('faq.components.WFaqLast'); ?>
	</div>
</div>
<?php $this->endContent(); // комментарий?>
