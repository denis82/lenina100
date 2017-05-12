<?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'title'=>'Действия',
    ));
        $this->widget('zii.widgets.CMenu', array(
            'items'=> array(
                array('label'=>'Список галерей',
                      'url'=>array('/expert/admin/index')),
                array('label'=>'Добавить галерею',
                      'url'=>array('/expert/admin/createExpert')),
            ),
        ));
    $this->endWidget();
?>