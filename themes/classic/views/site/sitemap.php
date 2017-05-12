<div id="templatemo_right">
	<div class="templatemo_section_3">
		<ul>
			<?php foreach ( $items as $i => $item ) : ?>
				<li>
    			<?php echo CHtml::link($item['label'], ! empty($item['url']) ? $item['url'] : $item['param']); ?>
				<?php if ( $item['level'] != 1 AND isset($items[$i+1]) ) : ?>
					<?php if ( $item['level'] < $items[$i+1]['level'] ) : ?>
						<ul>
					<?php elseif ( $item['level'] > $items[$i+1]['level'] ) : ?>
						</ul></li>
					<?php else : ?>
						</li>
					<?php endif; ?>
				<?php else: ?>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
    </div>
</div><!-- End of right -->