<?php

class WUploadImage extends CInputWidget
{
    public function init()
    {
        if ($this->hasModel()) {
            $this->value = CHtml::resolveValue($this->model, $this->attribute);
        }
        
        Yii::app()->clientScript
            ->registerCoreScript('jquery')
            ->registerScriptFile($this->assetPath.'/plupload.js')
            ->registerScriptFile($this->assetPath.'/plupload.html4.js')
            ->registerScriptFile($this->assetPath.'/plupload.html5.js')
        ;
    }
    
    public function run()
    {
        list($name, $id) = $this->resolveNameID();
        
        $this->render('wUploadImage', array(
            'name' => $name,
            'id' => $id,
        ));
    }
    
    private $_assetPath = null;
    public function getAssetPath()
    {
        if ($this->_assetPath===null) {
            $path = Yii::getPathOfAlias('filemanager.assets.plupload');
            $this->_assetPath = CHtml::asset($path);
        }
        
        return $this->_assetPath;
    }
}