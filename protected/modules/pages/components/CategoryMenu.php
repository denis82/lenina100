<?php
Yii::import('pages.models.Page');
class CategoryMenu extends Menu
{
	public function run()
    {
        $names = explode('/', '/services');
        if (count($names) < 1) {
            return;
        } 
        $parentCriteria = new CDbCriteria;
        $parentCriteria->condition = 'url = :url';
        $parentCriteria->params = array(':url' => '/' . $names[1]);
        $parent = Page::model()->find($parentCriteria);
        if (!$parent) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->order = 'lft';
        $items = $parent->descendants()->findAll($criteria);
        
        if (empty($items)) {
            return;
        }
        
        $this->render('MenuCategory', array('items' => $items));
    }
}

