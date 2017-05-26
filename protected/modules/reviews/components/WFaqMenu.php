<?php

class WFaqMenu extends CWidget
{
    public $visible = true;
    
    public function run()
    {
        if ( ! $this->visible )
            return;
        
		$criteria = new CDbCriteria;
		$criteria->order = 'weight ASC';
		
        $items = FaqCategory::model()->findAll($criteria);
		
        $this->render('wFaqMenu', array(
            'items'=>$items
        ));
    }
}

?>

