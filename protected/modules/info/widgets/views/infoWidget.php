<hr>
		<div class="block shadow">
			<div class="side-content side-content-help cf">
    <div class="block-name">Справочно-информационные материалы</div>
	<div class="block-links">
	<?php $count = count($items); 
		$last_class = 'margin:-16px 0 4px 0; display:block;';
		$span_class = 'display:inline-block; margin:8px 0 0 -14px;';
		$i=0;
	?>
    <?php foreach ($items as $item): ?>
		<?php 
			$i++;
			if ($i == $count) {
			  $last_class = "margin:-16px 0 24px 0; display:block;";
			  $span_class = "display:inline-block; margin:8px 0 0 -14px;";
			}
		?>
		<span style = "<? echo($span_class); ?>">−</span>
		<a href = "/info/<? echo($item['id']); ?>" style = "<? echo($last_class); ?>"><? echo($item['title']); ?></a>
    <?php endforeach; ?>
    
	</div>
			</div>
		</div>