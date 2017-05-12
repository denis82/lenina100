	<div class="sliderContent" style="width:100%;">
        <?php foreach ($items as $item) {
            echo CHtml::link (
				"<div class='item-name pfdintextcondpro'></div>
				<div class='item-num pfdintextcondpro'>".$item['num'].".</div>".
				CHtml::image ($item['full_image_url'],
                              '',
                              array('width' => '610', 'height' => '325')
				),
                '', array ('class' =>'item', 'style' => '')
			);
        } ?>
	</div>