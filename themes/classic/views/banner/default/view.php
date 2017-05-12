        <?php echo CHtml::tag('time', array('dateTime'=>Yii::app()->dateFormatter->format('yyy-MM-ddTHH:mm',
                              $model['create_time'])), 
                              Yii::app()->dateFormatter->format('d MMMM yyyy', $model['create_time']) 
                              . ' г.'); 
        ?>

        <?php echo CHtml::tag('h1', array(), $this->clips['content_title']); ?>
        <?php echo $model->description; ?>
        <ul>
            <?php foreach ($model->items as $item): ?>
                <li>
                    <?php echo CHtml::link(CHtml::image($item->min_image_url), $item->full_image_url,
                                           array('data-text'=>$item->image_description,
                                                 'rel'=>'banner-' . $data->id)); 
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>