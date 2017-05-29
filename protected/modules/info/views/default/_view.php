<?php if (empty($dataProvider)): ?>
    <p>Нет результата.</p>
<?php endif; ?>
<?php //  echo "<pre>"; var_dump($dataProvider->create_time); echo "</pre>";die();?>

    <div class="one-qa"> 
			<a href="/info/<?php echo $dataProvider->id;?>"><h3><?php echo $dataProvider->title; ?></h3></a>
			<div class="quest"><?php echo $dataProvider->content; ?></div>
	


    </div>
<hr>
<?php //if ($dataProvider->pagination!==false && 2 > 1): ?>

<div class="pager">
    <?php /*$this->widget('CLinkPager', array(
        'pages' => $dataProvider->pagination,
        'header' => '',
        'cssFile' => false,
        'prevPageLabel' => '&larr; Предыдущая',
        'nextPageLabel' => 'Следующая &rarr;',
    ));*/ ?>
</div>
<?php //endif; ?>