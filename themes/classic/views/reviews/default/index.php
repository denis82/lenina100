
<?php if (empty($dataProvider->data)): ?>
    <p>Нет вопросов.</p>
<?php endif; ?>

<?php foreach ($dataProvider->data as $data): ?>
    <div class="one-qa"> 
		<div class="question cf">
			<i class="black small name"><?php echo $data->name_review . ' оставил отзыв (' . Yii::app()->dateFormatter->format('dd.MM.yyyy', $data->create_time). ')'; ?></i>
			<div class="quest"><?php echo $data->reviews; ?></div>
		</div>
		<div class="cf"></div>
		<div class="answer">
			
			<div class="answer-text black small"><?php //echo $data->answer; ?></div>
		</div>
    </div>
<?php endforeach; ?>

<?php //if ($dataProvider->pagination!==false && 2 > 1): ?>

<div class="pager">
    <?php $this->widget('CLinkPager', array(
        'pages' => $dataProvider->pagination,
        'header' => '',
        'cssFile' => false,
        'prevPageLabel' => '&larr; Предыдущая',
        'nextPageLabel' => 'Следующая &rarr;',
    )); ?>
</div>
<?php //endif; ?>