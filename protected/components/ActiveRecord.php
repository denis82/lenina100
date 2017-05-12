<?php

class ActiveRecord extends CActiveRecord
{
    
    public function populateRecord($attributes,$callAfterFind=true)
    {
        $model = parent::populateRecord($attributes, $callAfterFind);
        if ($model!==null) {
            Yii::app()->identityMap->storeModel($model);
        }
        
        return $model;
    }
    
    public function sitemap($params=array())
    {
        $table = $this->tableName();
        $path = Yii::app()->getBaseUrl(true);
        $priority = 0.5;
        $condition = "";
        $id = 'id';

        extract($params);
        $sql = "select concat('$path', '', $id) as url, $priority as priority from $table ". $condition;

        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }
}