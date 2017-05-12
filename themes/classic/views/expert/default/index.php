	<?php $id = 0; $status = 'active'; ?>
	<?php foreach ($dataProvider->data as $category): ?>
		<div class="<?php echo $status; ?> specialists-<?php echo $id; ?>">
      <h2><?php echo $category['category_name']; ?></h2>
      <?php $items = $category['items']; $i = 1; 
			if (!$items) : ?> 
				<?php echo "<div class='specialist'>Специалистов нет.</div>";?>
			<?php else: ?>
      <?php $last = count($items);
			foreach ($items as $item): ?>
				<?php if ($item->view) :?>
					<div class="specialist">
									<?php
											echo CHtml::image($item->mid_image_url,
																					'',
																					array('width' => '120', 'height' => '101'));
									?>
							<div class="name"> <?php echo $item->name;?> </div>
							<p> <?php echo $item->image_description; ?> </p>
					</div>
					<?php if ($i != $last) echo '<hr>'; 
						$i++;
					?>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php endif; ?>
        </div>
		
	<?php endforeach; ?>
	<?php $status = 'hidden'; ?>
