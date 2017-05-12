<?php

$this->clips['title'] = 'Роли';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'dataProvider' => $dataProvider,
    
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'name' => 'id',
            'header' => 'Идентификатор',
        ),
        array(
            'name' => 'description',
            'header' => 'Описание',
        ),
        array(
            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
            'template' => '{update} {delete}',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("updateRole", "id" => $data["id"]))',
            'deleteButtonUrl' => 'CHtml::normalizeUrl(array("deleteRole", "id" => $data["id"]))',
            'htmlOptions' => array('style' => 'width: 50px'),
        ),
    ),
));


?>
