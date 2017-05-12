
<div class="item">
	<?php if ($data['logo_url']) :?> <img src = <?php echo $data['logo_url'] ?>> <?php endif; ?>
    <p class="data"><?php echo Yii::app()->dateFormatter->format('d MMMM yyy г.', $data['create_time']); ?></p>
    <h3><?php echo CHtml::link($data['title'],
                             '/news/'
                             . $data['id'],
                               array('title' => $data['title'])); ?>
    </h3>
	<?php echo $data['annotation']; ?>
</div>
