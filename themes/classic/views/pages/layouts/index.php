<?php $this->beginContent('//layouts/main'); ?>
<!--  LAST NEWS  -->
    <div class="last-news">
		<?php $this->widget('news.widgets.RecentNewsWidget'); ?>
    </div><!-- End of left -->
	
	<!--  SLIDER  -->
	<div class="slider-block cf">
		<div class="name pfdintextcondpro"><?php echo $this -> clips['content_title']; ?></div>
		<div class="slider" style="width:100%;">
			<?php $this->widget('banner.components.BigWheelWidget'); ?>
		</div>
	</div>
	<!--  end SLIDER  -->
	
	
	
    <div id="templatemo_right">
        <div class="templatemo_section_3">
            <?php echo $content; ?>
        </div>
        <div class="cleaner"></div>
    </div><!-- End of right -->
	
<?php $this->endContent(); ?>