<?php $this->beginContent('//layouts/main'); ?>

	<div id="templatemo_left">
    	<div class="templatemo_section_1">
        </div>
        <div class="templaemo_h_line"></div>
        <div class="templatemo_section_2"></div>
    </div>
	<!-- End of left -->
            
    <div id="templatemo_right">
    	<div class="templatemo_section_3">
        	<?php echo CHtml::tag('h1', array(), $this->clips['content_title']); ?>
			<?php echo $content; ?>
        </div>
        <div class="cleaner"></div>
    </div>
                
<?php $this->endContent(); ?>
