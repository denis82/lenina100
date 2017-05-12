<?php

$this->clips['title'] = 'Разделы';

?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'dataProvider' => $dataProvider,
    
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'name' => 'title',
            'value' => 'CHtml::link($data->title, array("index", "category_id"=>$data->id))',
            'type' => 'raw',
        ),
        array(
            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
            'template' => '{update} {delete}',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("updateCategory", "id"=>$data->id))',
            'deleteButtonUrl' => 'CHtml::normalizeUrl(array("deleteCategory", "id"=>$data->id))',
            'afterDelete' => 'function(){ window.location.reload(); }',
            'htmlOptions' => array('style' => '50px'),
        ),
    ),
)); ?>
