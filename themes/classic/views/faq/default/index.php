
<?php if (empty($dataProvider->data)): ?>
    <p>Нет вопросов.</p>
<?php endif; ?>

<?php foreach ($dataProvider->data as $data): ?>
    <div class="one-qa"> 
		<div class="question cf">
			<i class="black small name"><?php echo $data->name_q . ' спрашивает (' . Yii::app()->dateFormatter->format('dd.MM.yyyy', $data->create_time). ')'; ?></i>
			<div class="quest"><?php echo $data->quest; ?></div>
		</div>
		<div class="cf"></div>
		<div class="answer">
			<?php if ($data->expert->name) :?>
				<div><a class='expert_box' href="/expert_box/<?php echo $data->expert->id;?>"> </div>
					<img src="<?php echo $data->expert->min_image_url; ?>" style="border: 2px solid #BBBCBD;"></img>
				</a>
				<div class="answer-header">
					<a class='expert_box' href="/expert_box/<?php echo $data->expert->id;?>"><?php echo $data->expert->name; ?></a> отвечает 
				</div>
			<?php else: ?>
				<div class="answer-header"><a href=""><?php echo $data->name_a; ?></a> отвечает </div>
			<?php endif; ?>
			<div class="answer-text black small"><?php echo $data->answer; ?></div>
		</div>
    </div>
<?php endforeach; ?>

<?php if ($dataProvider->pagination!==false && $dataProvider->pagination->pageCount > 1): ?>
<div class="pager">
    <?php $this->widget('CLinkPager', array(
        'pages' => $dataProvider->pagination,
        'header' => '',
        'cssFile' => false,
        'prevPageLabel' => '&larr; Предыдущая',
        'nextPageLabel' => 'Следующая &rarr;',
    )); ?>
</div>
<?php endif; ?>