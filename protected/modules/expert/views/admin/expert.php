<?php
    $assetManager = Yii::app()->assetManager;
    $assetsPath = $assetManager->publish(Yii::getPathOfAlias('webroot.themes.classic.assets'));
    $clientScript = Yii::app()->clientScript;
    $clientScript->registerCssFile($assetsPath . '/js/fancybox/jquery.fancybox-1.3.4.css')
                 ->registerScriptFile($assetsPath . '/js/fancybox/jquery.fancybox-1.3.4.pack.js')
                 ->registerScript('fancybox', "
                    $('.view').fancybox();   
                 ");
?>
<?php
    $this->clips['buttons'] = array(
		CHtml::link(BHtml::icon('plus white')." Добавить сотрудника", array('/expert/admin/createItem', 'expert_id'=>$expert->id), array('class'=>'btn btn-primary')),
    );

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            array(
                'header' => 'Превью',
                'value' => 'CHtml::image($data["min_image_url"])',
                'type' => 'raw',
            ),
            array(
                'header' => 'Дата загрузки',
                'value' => 'Yii::app()->dateFormatter->format("dd MMMM yyyy", $data["create_time"])',
                'name' => 'create_time',
            ),
			array(
                'header' => 'ФИО сотрудника',
                'value' => '$data["name"]',
                'name' => 'name',
            ),
            array(
                'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                'template' => '{view} {update} {delete}',
                'viewButtonUrl' => '$data["full_image_url"]',
                'updateButtonUrl' => 'Yii::app()->createUrl("/expert/admin/updateItem", '
                                     . 'array("item_id"=>$data["id"]))',
                'deleteButtonUrl' => 'Yii::app()->createUrl("/expert/admin/deleteItem", '
                                     . 'array("item_id"=>$data["id"]))',
            ),
        )
    ));
?>
