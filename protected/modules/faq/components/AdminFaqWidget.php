<?php
class AdminFaqWidget extends CWidget
{

    public $categories;

    public function init() {
        $this->categories = FaqCategory::model()->findAll();
    }

    public function run() 
    {
        $this->render('adminWidget', array('categories'=>$this->categories));
    }
    
}
