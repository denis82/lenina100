<div class="tree">
    <ul>
        <?php $length = count($items); ?>
        <?php for($i=0; $i < $length; $i++): ?>
            <?php $current = $items[$i]; ?>
            <?php $next = isset($items[$i+1]) ? $items[$i+1] : array(); ?>
            <?php echo CHtml::openTag("li", array(
                'id' => 'node-'.$current['id'],
                'class' => (strpos(Yii::app()->request->pathInfo, $current['id']) ? 'active' : '')
            )); ?>
            <?php echo CHtml::link($current['label'],
                                   array('update',
                                         'id' => $current['id']),
                                   array('data-child-url' => Yii::app()->createAbsoluteUrl('/pages/admin/child', array ('id' => $current['id'])),
                                         'data-delete-url' => Yii::app()->createAbsoluteUrl('/pages/admin/delete', array ('id' => $current['id'])),
                                         'data-id' => $current['id'],
                                         'class' => (strpos(Yii::app()->request->queryString, $current['id']) ? 'active' : '') .' jstree-open'
                        )); ?>
            <?php if (isset($next) && !empty($next)): ?>

                <?php if ($current['level'] > $next['level']): ?>
                    <?php echo CHtml::closeTag('li')
                             . str_repeat(CHtml::closeTag('ul') . CHtml::closeTag('li'), $current['level'] - $next['level']); ?>
                <?php elseif ($current['level'] < $next['level']): ?>
                    <?php echo CHtml::openTag('ul');?>
                <?php else: ?>
                    <?php echo CHtml::closeTag('li'); ?>
                <?php endif; ?>

            <?php else: ?>
                <?php if($items[0]['level'] < $current['level']): ?>
                    <?php echo CHtml::closeTag('li')
                             . str_repeat(CHtml::closeTag('ul') . CHtml::closeTag('li'), $current['level'] - $items[0]['level']); ?>
                <?php else: ?>
                    <?php CHtml::closeTag('li'); ?>
                <?php endif; ?>

            <?php endif; ?>

        <?php endfor; ?>
    </ul>
</div>
