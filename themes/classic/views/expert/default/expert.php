<div class="item_photo">
    <?php echo CHtml::tag('time', array('dateTime'=>Yii::app()->dateFormatter->format('yyy-MM-ddTHH:mm',
                          $data['create_time'])), 
                          Yii::app()->dateFormatter->format('d MMMM yyyy', $data['create_time']) 
                          . ' г.'); 
    ?>
    <?php echo CHtml::link($data->name, array('/expert/default/view', 'url'=>$data->url),
                           array('title'=>$data->name, 'class'=>'album')); 
    ?>
    <?php echo $data->description; ?>
    <ul>
        <?php foreach ($data->items as $item): ?>
            <li>
                <?php echo CHtml::link(CHtml::image($item->min_image_url), $item->full_image_url,
                                       array('data-text'=>$item->image_description,
                                             'rel'=>'expert-' . $data->id)); 
                ?>
            </li>
        <?php endforeach; ?>
    </ul>
	<a class="more" href="">Ещё сотрудники</a>
</div>