<?php

class IdentityMap extends CApplicationComponent
{
    private static $_models = array();
    
    public function loadModel($className, $id)
    {
        $key = $className . '.' . (is_array($id) ? implode('.', $id) : $id);
        
        if (!isset(self::$_models[$key])) {
            $model = ActiveRecord::model($className)->findByPk($id);
            if ($model===null) {
                throw new CHttpException(404);
            }
            self::$_models[$key] = $model;
        }
                
        return self::$_models[$key];
    }
    
    public function existsModel($className, $id)
    {
        $key = $className . '.' . (is_array($id) ? implode('.', $id) : $id);
        
        if (isset(self::$_models[$key])) {
            return false;
        } else {
            return true;
        }
    }
    
    public function storeModel(CActiveRecord $model)
    {
        $key = $this->globalKey($model);
        self::$_models[$key] = $model;
    }
    
    protected function globalKey(CActiveRecord $model)
    {
        $key = $model->getPrimaryKey();
        if (is_array($key)) {
            $key = implode('.', $key);
        }
        
        return get_class($model) . '.' . $key;
    }
}