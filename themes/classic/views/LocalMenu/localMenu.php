<ul>
	<?php $length = count($items); ?>

	<?php for($i=0; $i < $length; $i++): ?>
			<?php $current = $items[$i]; $next = isset($items[$i+1]) ? $items[$i+1] : array(); ?>
			<?php
				$options = array();
				$url = empty($current['param']) ? $current['url'] : $current['param'];
				$options['class'] = $this->isActive($url) ? 'active' : '';
			?>
			<?php echo CHtml::openTag('li', $options); ?>
			<?php echo CHtml::link($current['label'], $url,
									array('title' => $current['label'])); 
			?>

			<?php if(isset($next) && !empty($next)): ?>
					<?php if($current['level'] > $next['level']): ?>
						<?php echo "</li>".str_repeat("</ul></li>", $current['level'] - $next['level']); ?>
					<?php elseif($current['level'] < $next['level']): ?>
							<ul>
					<?php else: ?>
							</li>
					<?php endif; ?>

			<?php else: ?>
					<?php if($items[0]['level'] < $current['level']): ?>
						<?php echo "</li>".str_repeat("</ul></li>", $current['level'] - $items[0]['level']); ?>
					<?php else: ?>
						</li>
					<?php endif; ?>
			<?php endif; ?>

	<?php endfor; ?>
</ul>
