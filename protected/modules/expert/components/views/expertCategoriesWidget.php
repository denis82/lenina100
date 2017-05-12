<?php $id = 0; ?>    
<?php foreach ($items as $item): ?>
	<?php
		if ($item['name'] == 'Администрация') continue;
		$id++;
		$options = '';
		if(strpos (Yii::app()->request->pathInfo, $item['url']) !== false)
				$options = 'active';
	?>
	<?php echo 
		CHtml::link($item['name'] . '<span class="arrow"></span>',
				array('/expert/'.$item['url']),
				array('title' => $item['title'], 'class' => $options, 'name-id'=>$id)
		); 
	?>
<?php endforeach; ?>