<?php
    echo BHtml::flash();

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'dataProvider' => $dataProvider,
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Название',
                'value' => '$data["name"]',
                'name' => 'name',
            ),
            array(
                'header' => 'Дата создания',
                'value' => 'Yii::app()->dateFormatter->format("dd MMMM yyyy", $data["create_time"])',
                'name' => 'create_time',
            ),
            array(
                'header' => 'Количество фотографий',
                'value' => 'CHtml::link($data->itemsCount, '
                           . 'array("/banner/admin/indexBanner", "banner_id"=>$data["id"]))',
                'type' => 'raw',
            ),
            array(
                'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                'template' => '{view} {update} {delete}',
                'viewButtonUrl' => 'Yii::app()->createUrl("/banner/admin/indexBanner",'
                                   . ' array("banner_id"=>$data["id"]))',
                'updateButtonUrl' => 'Yii::app()->createUrl("/banner/admin/updateBanner",'
                                   . ' array("banner_id"=>$data["id"]))',
                'deleteButtonUrl' => 'Yii::app()->createUrl("/banner/admin/deleteBanner",'
                                   . ' array("banner_id"=>$data["id"]))',
            )
        )
    ));
?>
