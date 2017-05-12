<?php
class FileBrowser extends CWidget
{
	
	public $options = array();
	public $htmlOptions = array();
	
	public function run()
	{
		$this->htmlOptions['id'] = $this->getId();
		$assetManager = Yii::app()->assetManager;
		$clientScript = Yii::app()->clientScript;
		
		$basePath = $assetManager->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
		
		$clientScript->registerCoreScript('jquery.ui')
					 ->registerCssFile($basePath . '/css/elfinder.css')
					 ->registerCssFile($basePath . '/css/smoothness/jquery-ui-1.8.13.custom.css')
					 ->registerScriptFile($basePath . '/js/elfinder.min.js')
					 ->registerScriptFile($basePath . '/js/i18n/elfinder.' . Yii::app()->language . '.js');
					 
		$clientScript->registerScript('el'.$this->getId(),'jQuery("#'.$this->getId().'").elfinder('.CJavaScript::encode($this->options).')',  CClientScript::POS_READY);
		
		echo CHtml::openTag('div', $this->htmlOptions);
		echo CHtml::closeTag('div');
	}
}
