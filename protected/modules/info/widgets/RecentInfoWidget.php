<?php

Yii::import('info.models.*');

/**
 * Виджет выводит последние статьи
 */
class RecentInfoWidget extends CWidget
{
    public $visible = true;
    public $limit = 5;
    public $view = 'infoWidget';

    public function run()
    {
		if (!$this->visible) {
            return;
        }
		$criteria = new CDbCriteria;
		$adr = explode('/', $_SERVER['REQUEST_URI']);
		$adr = $adr[2];
		$criteria->condition = "url = :adr";
		$criteria->params = array(':adr' => $adr);
		$id_category = InfoCategory::model()->find($criteria);
		
        $criteria = new CDbCriteria();
        $criteria->condition = 'status = :status';
		if ($id_category) {
			$id_category = $id_category['id'];
			$criteria->addCondition('category_id = '.$id_category);
		}
        $criteria->addCondition('create_time <= :time');
        $criteria->addCondition('expire_time >= :time');
        $criteria->params = array(':time' => time(),
                                  ':status' => InfoItem::STATUS_PUBLISHED);
        $criteria->order = 'create_time DESC';
        $criteria->limit = $this->limit;
        $items = InfoItem::model()->findAll($criteria);
		if (!$items) return 0;
        $this->render($this->view, array('items'=>$items));
    }
}

