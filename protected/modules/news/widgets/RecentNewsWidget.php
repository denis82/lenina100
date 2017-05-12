<?php

Yii::import('news.models.*');

/**
 * Виджет выводит последние новости
 */
class RecentNewsWidget extends CWidget
{
    public $visible = true;
    public $limit = 2;
    public $view = 'newsWidget';

    public function run()
    {
		if (!$this->visible) {
            return;
        }
        $criteria = new CDbCriteria();
        $criteria->condition = 'status = :status';
        $criteria->addCondition('create_time <= :time');
        $criteria->addCondition('expire_time >= :time');
        $criteria->params = array(':time' => time(),
                                  ':status' => NewsItem::STATUS_PUBLISHED);
        $criteria->order = 'create_time DESC';
        $criteria->limit = $this->limit;
        $items = NewsItem::model()->findAll($criteria);
        //if (empty($items)) {
        //    return;
        //}
        $this->render($this->view, array('items'=>$items));
    }
}

