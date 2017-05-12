<?php

Yii::import('banner.models.*');

// Виджет выводит последние баннеры
class BannerWidget extends CWidget
{
    public $limit = 100;
    public $view = 'bannerWidget';
	public $condition = 'url = :name';
	public $params = array(':name' => '/banner');

    public function run()
    {
		/*-*/
		$items = BannerItem::model()->findAll(array(
			'with' => array(
				'banner' => array(
					'condition' => $this->condition,
					'params'=>$this->params,
				),
			),
			'limit' => $this->limit,
			'order'=>'t.create_time DESC',
		));
		
		//$criteria = new CDbCriteria();
        //$criteria->order = 'create_time DESC';
        //$criteria->limit = $this->limit;
		//$criteria->condition = $this->condition;
		//$criteria->params = $this->params;
        //$items = BannerItem::model()->findAll($criteria);
        if (empty($items)) {
            return;
        }
        $this->render($this->view, array('items'=>$items));
    }
}

?>