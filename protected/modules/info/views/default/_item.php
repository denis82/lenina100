<div>
    <?php echo CHtml::tag('time',
                          array('datetime' => Yii::app()->dateFormatter->format('yyy-MM-ddTHH:mm',
                                                                                $data['create_time'])),
                          Yii::app()->dateFormatter->format('dd MMMM yyyy', $data['create_time'])); ?>
    <?php if ($this->withCategories): ?>
        <h2><?php echo CHtml::link($data['title'], array('/info/default/view',
                                                         'category_url' => $data['category']['url'],
                                                         'id' => $data['id'])); ?></h2>
    <?php else: ?>
        <h2><?php echo CHtml::link($data['title'], array('/info/default/view',
                                                         'id' => $data['id'])); ?></h2>
    <?php endif; ?>
    <?php echo $data['annotation']; ?>
</div>

