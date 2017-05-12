<?php
$this->clips['title'] = 'Вопросы';

echo CHtml::beginForm();

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'dataProvider'=>$dataProvider,
    
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns'=>array(
        'name_q',
        'quest',
        array(
            'name'=>'name_a',
            'visible' => isset($_GET['catId']),
        ),
        array(
            'name'=>'answer',
            'visible' => isset($_GET['catId']),
        ),
        array(
            'value' => 'CHtml::activeTextField($data, "[$data->id]weight", array("class"=>"span1"))',
            'name' => 'weight',
            'type' => 'raw',
            'visible' => isset($_GET['catId']),
        ),
        array(
            'name' => 'status',
            'value' => 'CHtml::activeDropDownList($data, "[$data->id]status", $data->statusOptions, array("class"=>"span2"))',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'width: 80px'),
        ),
        array(
            'name' => 'visible',
            'value' => 'CHtml::activeDropDownList($data, "[$data->id]visible", $data->visibilityOptions, array("class"=>"span2"))',
            'type' => 'raw',
            'visible' => isset($_GET['catId']),
            'htmlOptions' => array('style' => 'width: 80px'),
        ),
        array(
            'header'=>'Действия',
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{update} {delete}',
            'htmlOptions' => array('style' => 'width: 50px'),
        ),
    )
));

if (!empty($dataProvider->data)) {
    echo CHtml::tag('div', array('class'=>'form-actions'),
        CHtml::htmlButton('<i class="icon-ok icon-white"></i> Сохранить изменения', array('class' => 'btn btn-primary', 'type' => 'submit'))
        .CHtml::tag('span', array(), '&nbsp;&nbsp;&nbsp;&nbsp;')
        .CHtml::htmlButton('<i class="icon-repeat"></i> Отменить изменения', array('class' => 'btn', 'type' => 'reset'))
    );
}
echo CHtml::endForm();

?>
