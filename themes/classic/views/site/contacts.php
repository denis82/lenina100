<div class="main">
	<h1><?php echo $this->clips['content_title']; ?></h1>
	
    <?php echo $content; ?>
</div><!-- End of left -->

<div class="sidebar">
	<div class="block shadow cf">
        <div class="side-content side-content-form first cf">
			<?php $this->renderPartial('_feedback', array('model'=>$model)); ?>
		</div>
    </div>
</div><!-- End of right -->