
	<?php 
        $i = 0;
		$b = array();
		$cs = array();
		foreach ($items as $key=>$item) {
			$b[] = $item; $i++;
			if ($i==3){ $cs[] = $b; $b = array(); $i=0; }
		}
		if ($i > 0) {$cs[] = $b; $b = array(); $i=0; }
		
		echo CHtml::openTag('div', array('class'=>'items'));
		foreach ($cs as $row) {
			echo CHtml::openTag('div');
			$class = 'first';
			foreach ($row as $banner) {
				echo CHtml::link (CHtml::image ($banner['full_image_url'],
                                                $banner['image_description'],
                                                array('title' => $banner['image_description'])),
                                  $banner['banner_url'], array ('class' => $class));
				$class = '';
			}
			echo CHtml::closeTag('div');
		}
		echo CHtml::closeTag('div');
	?>
	