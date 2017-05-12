<?php

Yii::import('banner.models.*');

//Виджет выводит последние баннеры из раздела wheel
class BigWheelWidget extends CWidget
{
    public $limit = 10;
    public $view = 'BigWheelWidget';
	public $condition = 'url = :name';
	public $params = array(':name' => '/wheel');

    public function run()
    {
		$items = BannerItem::model()->findAll(array(
			'with' => array(
				'banner' => array(
					'condition' => $this->condition,
					'params'=>$this->params,
				),
			),
			'order' => 'num ASC',
		));
        if (empty($items)) {
            return;
        }
        $this->render($this->view, array('items'=>$items));
    }
}

?>