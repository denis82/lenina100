<div class="main news">
<p class="date">
    <?php echo Yii::app()->dateFormatter->format('d MMMM yyy г.', $item['create_time']); ?>
</p>
<h1><?php echo $item->title; ?></h1>
<p>
<?php if ($data['logo_url']) :?>
	<?php echo CHtml::image($item['logo_url'], '', array('align'=>'left')); ?>
<?php endif; ?>
<?php echo $item['content']; ?>
</p>
<a href="/news" class="all-news small" title="Назад к новостям">Все новости</a>
</div>