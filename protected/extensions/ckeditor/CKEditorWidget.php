<?php

class CKEditorWidget extends CInputWidget 
{

    public $editorOptions = array();
    public $skin = 'office2003';
    public $contentCss = 'contents.css';
    public $adapter = 'jquery.js';
    public $allowFileManager = true;

    public function init() 
    {
        $ckFilesPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ckeditor');
        $basePath = $ckFilesPath . '/';
        
        Yii::app()->clientScript->registerScriptFile($basePath . 'ckeditor.js');
        Yii::app()->clientScript->registerScriptFile($basePath . 'adapters/' . $this->adapter);
        
        $options = CJSON::encode($this->editorOptions);
        $name = $this->resolveNameID();
        $name = $name[0];
        $script = "
            CKEDITOR.basePath = '{$basePath}';
            CKEDITOR.config.contentsCss = '{$basePath}{$this->contentCss}';
            CKEDITOR.config.skin = '{$this->skin}';
            CKEDITOR.config.filebrowserBrowseUrl = '" . Yii::app()->createUrl('/filemanager/admin/index') . "';
            CKEDITOR.replace('{$name}',{$options});
            editorInstances = CKEDITOR.instances;
		";

        Yii::app()->clientScript->registerScript("ckeditor_{$name}", $script);
    }

    public function run() 
    {
        $this->render("ckwidget");
    }

}
