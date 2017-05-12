
    <?php foreach ($items as $item): ?>
            <?php
                    $options = '';
                    if(strpos (Yii::app()->request->pathInfo, $item['url']) !== false)
                        $options = 'active';
					if ($item['url'] == ' ' && Yii::app()->request->pathInfo == 'faq') $options = 'active';
            ?>
            <?php echo 
                    CHtml::link($item['title'] . '<span class="arrow"></span>',
                            array('/faq/'.$item['url']),
                            array('title' => $item['title'], 'class' => $options)
					); 
			?>
    <?php endforeach; ?>

