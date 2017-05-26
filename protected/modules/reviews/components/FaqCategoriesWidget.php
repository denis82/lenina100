<?php

class FaqCategoriesWidget extends CWidget
{
	public $visible = true;

	public function run()
	{
		if ( ! $this->visible )
			return;
		
		$sql = 'SELECT * FROM {{faq_category}} ORDER BY weight';
		$items = Yii::app()->db->createCommand($sql)->queryAll();

		if ( empty($items) )
			return;
		
		$this->render('faqCategoriesWidget', array(
			'items' => $items,
		));
	}
}