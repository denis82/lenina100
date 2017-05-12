<?php
$this->clips['title'] = 'Справочник';

foreach ($statuses as $value => $label) {
    $items[] = array(
        'label' => $label,
        'url' => CHtml::normalizeUrl(array('index', 'filter' => $value)),
        'active' => (isset($_GET['filter']) && $_GET['filter'] == $value) || (!isset($_GET['filter']) &&$value == 'all'),
    );
}

$this->widget('ext.bootstrap.widgets.BootMenu', array(
    'type' => 'pills',
    'stacked' => false,
    'items' => $items,
));

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'dataProvider' => $dataProvider,
    
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns'=>array(
        array(
            'header' => 'Заголовок',
            'value' => '$data->title',
            'name' => 'title',
        ),
        array(
            'header'=>'Дата создания',
            'value'=>'$data->createTime',
            'type'=>'raw',
            'name' => 'create_time',
        ),
        array(
            'header' => 'Дата истечения актуальности',
            'value' => '$data->expireTime',
            'name' => 'expire_time',
        ),
        /*array(
            'header' => 'Отображается в RSS',
            'value' => '$data->visible_in_rss ? "<i class=\"icon-ok\"></i> " : ""',
            'name' => 'visible_in_rss',
            'type' => 'raw',
        ),*/
        array(
            'class'=>'ext.bootstrap.widgets.BootButtonColumn',
            'template'=>'{update} {delete}',
            'htmlOptions' => array('style' => 'width: 50px'),
        )
    )
));
?>
