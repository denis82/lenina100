<h1>Категория "<?php echo $categoryTitle; ?>" </h1>

<?php echo BHtml::flash(); ?>

<p>
    <?php echo CHtml::link('Назад',array('index')); ?> |
    <?php echo CHtml::link('Добавить вопрос',array('create', 'categoryId'=>$categoryId)); ?>
</p>
<hr />
<?php echo CHtml::beginForm(); ?>
<table>
<?php foreach($models as $i=>$model): ?>
    <tr>
	<td><?php echo CHtml::activeTextField($model, "[{$i}]weight",array('size'=>1)); ?></td>
	<td><?php echo CHtml::activeHiddenField($model, "[{$i}]id"); ?></td>
	<td>
	    <p><strong><?php echo $model->name_q; ?> спрашивает:</strong><br />
	    <?php echo $model->quest; ?></p>
	    <p><strong><?php echo $model->name_a; ?> отвечает:</strong><br />
	    <?php echo $model->answer; ?></p>
	</td>
	<td>
	    <u>Создан:</u><br />
	    <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy',$model->create_time); ?><br />
	    <u>Обновлен:</u> <br />
	    <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy',$model->update_time); ?><br />

	    <?php echo CHtml::link('Редактировать', array('update', 'id'=>$model->id)); ?><br />
	    <?php echo CHtml::link('Удалить', array('delete', 'id'=>$model->id)); ?>
	</td>
    </tr>
<?php endforeach; ?>
</table>
<div class="actions">
    <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn primary')); ?>
</div>
<?php echo CHtml::endForm(); ?>