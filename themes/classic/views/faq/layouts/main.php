<?php $this->beginContent('//layouts/main'); ?>
	<div class="main">
		<?php echo CHtml::tag('h1', array(), $this->clips['content_title']); ?>
    	<div class="quest">
    	    <?php $this->widget('faq.components.FaqCategoriesWidget'); ?>
        </div>
        <div class="questions-list">
			<?php echo $content; ?>
		</div>
    </div><!-- End of left -->
    
    <div class="sidebar">
    	<div class="block shadow cf">
			<div class="side-content side-content-form first cf">
				<?php $this->widget('faq.components.NewQuestionWidget'); ?>
			</div>
        </div>

				<?php $this->widget('info.widgets.RecentInfoWidget'); ?>

		<hr>
		<div class="block">
			<div class="side-content side-content-advise cf">
				<?php $this->widget('expert.components.ExpertWidget'); ?>
			</div>
        </div>
    </div><!-- End of right -->
<?php $this->endContent(); ?>
