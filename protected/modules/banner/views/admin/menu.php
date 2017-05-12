<?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'title'=>'Действия',
    ));
        $this->widget('zii.widgets.CMenu', array(
            'items'=> array(
                array('label'=>'Список разделов баннеров',
                      'url'=>array('/banner/admin/index')),
                array('label'=>'Добавить раздел баннеров',
                      'url'=>array('/banner/admin/createBanner')),
            ),
        ));
    $this->endWidget();
?>