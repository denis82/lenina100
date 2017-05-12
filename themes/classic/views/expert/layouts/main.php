<?php $this->beginContent('//layouts/main'); ?>

	<div class="main">
		<?php echo CHtml::tag('h1', array(), $this->clips['content_title']); ?>
		<div class="questions-menu specialists-list">
			<?php $this->widget('expert.components.ExpertCategoriesWidget'); ?>
		</div>
		<?php echo $content; ?>
    </div>
	<!-- End of left -->
            
    <div class="sidebar">

		<div class="block-questions">
			<?php $this->widget('faq.components.WFaqLast'); ?>
		</div>
    </div>
                
<?php $this->endContent(); ?>
