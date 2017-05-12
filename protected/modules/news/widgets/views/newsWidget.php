
    <div class="block-name">Новости</div>
    <div class="items">
    <?php foreach ($items as $item): ?>
		<div class="item cf">
		<?php echo CHtml::tag('p',
              array('class' => 'date'),
              Yii::app()->dateFormatter->format('d MMMM yyyy', $item['create_time'])); ?>
		
        <?php $module = Yii::app()->getModule('news'); ?>
            <h3><?php echo CHtml::link($item['title'], array('/news/default/view',
                                                             'id' => $item['id'])); ?></h3>

			<p><?php echo $item->annotation; ?></p>
		</div>
    <?php endforeach; ?>
    
	</div>
    <?php echo CHtml::link('Все новости', 
                           array('/news/default/index'), 
                           array('title'=>'Все акции и спецпредложения', 'class'=>'all-news')); 
    ?>
