<?php

Yii::import('expert.models.*');

/**
 * Виджет выводит последние новости
 */
class ExpertWidget extends CWidget
{
    public $limit = 6;
    public $view = 'expertWidget';

    public function run()
    {
		$criteria = new CDbCriteria;
		$adr = explode('/', $_SERVER['REQUEST_URI']);
		$adr = $adr[2];
		$criteria->condition = "url = :adr";
		$criteria->params = array(':adr' => $adr);
		$id_category = Expert::model()->find($criteria);
		
        $criteria = new CDbCriteria();
		if ($id_category) {
			$id_category = $id_category['id'];
			$criteria->condition = 'expert_id = '.$id_category;
		}
        $criteria->order = 'create_time DESC';
        $criteria->limit = $this->limit;
        $items = ExpertItem::model()->findAll($criteria);
        if (empty($items)) {
            return;
        }
        $this->render($this->view, array('items'=>$items));
    }
}

?>