<?php

$this->clips['title'] = 'Пользователи';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'dataProvider' => $dataProvider,
    
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'name' => 'name',
            'htmlOptions' => array('style' => 'width: 200px;'),
        ),
        array(
            'name' => 'create_time',
            'header' => 'Дата регистрации',
            'value' => 'date("j.n.Y", $data->create_time)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'width: 100px'),
        ),
        array(
            'name' => 'email',
            'htmlOptions' => array(
                //'style' => 'width: 120px',
            ),
        ),
        array(
            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
            'template' => '{update} {delete}',
            'htmlOptions' => array('style' => 'width: 50px'),
        ),
    ),
));

?>

