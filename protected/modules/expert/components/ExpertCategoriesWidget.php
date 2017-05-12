<?php

class ExpertCategoriesWidget extends CWidget
{
	public $visible = true;

	public function run()
	{
		if ( ! $this->visible )
			return;
		
		$sql = 'SELECT * FROM {{expertes}} ORDER BY id';
		$items = Yii::app()->db->createCommand($sql)->queryAll();

		if ( empty($items) )
			return;
		
		$this->render('expertCategoriesWidget', array(
			'items' => $items,
		));
	}
}