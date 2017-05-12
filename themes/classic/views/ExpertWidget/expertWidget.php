<div class="block-name"> Консультируют специалисты </div>
<div class="block-content">
        <?php foreach ($items as $item) {
            echo CHtml::openTag('div', array('class'=>'doc'));
            echo CHtml::link (CHtml::image ($item['min_image_url'],
                                '',
                                array('title' => $item['image_description'])),
								  "/expert_box/" . $item['id'], array ('class' =>'thickbox expert_box'));
			echo CHtml::link ( $item['name'],
                                  "/expert_box/" . $item['id'], array ('class' =>'thickbox expert_box'));
			echo CHtml::openTag('div', array('class'=>'small black prof'));
			echo $item['image_description'];
			echo CHtml::closeTag('div');
			echo CHtml::closeTag('div');
		} ?>
</div>