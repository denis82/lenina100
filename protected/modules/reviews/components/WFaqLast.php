<?php

Yii::import('faq.models.*');

class WFaqLast extends CWidget
{
    public $limit = 4;

    public function run(){
		$criteria = new CDbCriteria;
		$adr = explode('/', $_SERVER['REQUEST_URI']);
		$adr = $adr[2];
		$criteria->condition = "url = :adr";
		$criteria->params = array(':adr' => $adr);
		$id_category = FaqCategory::model()->find($criteria);
		
		$criteria = new CDbCriteria;
		$criteria->condition = "status = :status";
		if ($id_category) {
			$id_category = $id_category['id'];
			$criteria->addCondition('category_id = '.$id_category);
		}
		$criteria->params = array(
			':status' => 'faq_answered',
		);
		$criteria->order = 'create_time DESC';
		$criteria->limit = $this->limit;
		$faqs = Faq::model()->findAll($criteria);
		if (!$faqs) return 0;
		$this->render('wFaqLast',array('faqs'=>$faqs));
    }
}
// комментарий
?> 