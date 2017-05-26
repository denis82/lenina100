<h2>Просмотр и редактирование категорий</h2>

<?php echo BHtml::flash(); ?>


<?php echo CHtml::beginForm(array('category'), 'post', array('id'=>'formCategory', 'class'=>'form-stacked')); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'dataProvider'=>$dataProvider,
            'ajaxUpdate'=>false,
			'cssFile'=>false,
            'columns'=>array(
                array(
                    'header'=>'Название категории',
                    'value'=>'CHtml::activeTextField($data, "[{$data->id}]title")',
                    'type'=>'raw'
                ),
                array(
                    'header'=>'Url категории',
                    'value'=>'CHtml::activeTextField($data, "[{$data->id}]url")',
                    'type'=>'raw'
                ),
                array(
                    'header'=>'Вес категории',
                    'value'=>'CHtml::activeTextField($data, "[{$data->id}]weight")',
                    'type'=>'raw'
                ),
                array(
                    //'header'=>'Действия',
                    'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                    'htmlOptions' => array('style' => 'width: 20px'),
                    'template'=>'{delete}',
                    'deleteButtonUrl'=>'$this->grid->owner->createUrl("deleteCategory", array("catId"=>$data->id))'
                ),
            )
        ));
    ?>
<div class="form-actions">
    <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn btn-primary')); ?>
</div>
<?php echo CHtml::endForm(); ?>
