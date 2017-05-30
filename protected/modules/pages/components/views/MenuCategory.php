<ul class="main-menu">
	<?php 
		$length = count($items);
		$j=0; 
		$sub_menu = false; 
		$flag = 0; 
		$sub_items = array();
	?>
	
	<?php for($i=0; $i < $length; $i++) { 
			$current = $items[$i];
			if ($current['level'] > 3) { 
				if ($flag) {
					if ($flag != $j) $flag = 0;
					else {
						$sub_items[] = $current;
						$sub_menu = $items[$i]['url'];
					}
				}
				continue;
			}
			$next = isset($items[$i+1]) ? $items[$i+1] : array(); 
			$options = array();
			$url = empty($current['param']) ? $current['url'] : $current['param'];
			$j++;
			if ($this->isActive($url)) {
				$flag = $j;
			}
			$options['class'] = $this->isActive($url) ? 'active' : '';
			$options['id'] = $j;
			
			echo CHtml::openTag('li', $options);  
// 			if ($j == 3) {
// 				echo '<img src="/themes/classic/assets/images/people.png" class="people1">';
// 			}
			
			echo CHtml::link($current['image_menu'].'<span>'.$current['label'].'</span>', $url,
								array('title' => $current['label'],
									'class' => 'cf',
								)
							); 
			echo '<span class="menu-arrow"></span>';
		}
	?>
</ul>

<?php if ($sub_menu):?>
<script>
  $(document).ready(function(){
    $('div.content').css({marginTop:60});
  });
</script>
<div class = "sub-menu">
    <span class = "in"></span>
    <span class = "out"></span>
	<div class = "sub-content">
		<?php
		$j = 1;
		$length = count($sub_items);
		$percent = (90 / $length);
		$need_class = '';
		foreach ($sub_items as $current) {
			$class_local = $this->isActive($current['url']) ? 'active' : '';
			if ($j == $length) $need_class = 'no-separator';
			echo CHtml::openTag('div', array('style' => "width: $percent%", 'class' => $need_class));
			echo CHtml::link($current['label'], $current['url'],
								array('title' => $current['label'],
									'class' => 'sub-link '.$class_local,
								)
							);
			echo CHtml::closeTag('div');
			$j++;
		}
		?>

	</div>
</div>
<?php endif; ?>