
<div class="item">
    <h3><?php echo CHtml::link($data['title'],
                             '/info/'
                             . $data['id'],
                               array('title' => $data['title'])); ?>
    </h3>
	<?php echo $data['annotation']; ?>
</div>
