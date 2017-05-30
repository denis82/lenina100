<ul class="no_marker">
<?php foreach ($items as $item): ?>
        <?php
                $options = array();
                if(strpos (Yii::app()->request->pathInfo, $item['url']) !== false)
                    $options['class'] = 'active';
        ?>
        <?php echo CHtml::tag('li', $options,
                CHtml::link($item['title'],
                        array('/faq/'.$item['url']),
                        array('title' => $item['title']))
        ); ?>
<?php endforeach; ?>
</ul>