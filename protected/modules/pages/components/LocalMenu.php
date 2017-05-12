<?php
Yii::import('pages.models.Page');
class LocalMenu extends Menu
{
    public function run()
    {
        $names = explode('/', Yii::app()->request->pathInfo);
        if (count($names) < 1) {
            return;
        } 
        $parentCriteria = new CDbCriteria;
        $parentCriteria->condition = 'url = :url';
        $parentCriteria->params = array(':url' => '/' . $names[0]);
        $parent = Page::model()->find($parentCriteria);
        if (!$parent) {
            return;
        }
        $criteria = new CDbCriteria;
        $criteria->order = 'lft';
        $descendants = $parent->descendants()->findAll($criteria);
        
        if (empty($descendants)) {
            return;
        }
        
        $this->render('localMenu', array('items' => $descendants));
    }

}
