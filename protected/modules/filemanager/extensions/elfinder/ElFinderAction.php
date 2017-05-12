<?php 
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elFinder.class.php';
class ElFinderAction extends CAction
{
	public $options = array();
	
	public function run()
	{
		$options = array();
		$options['root'] = Yii::getPathOfAlias('webroot.files');
		$options['URL'] = Yii::app()->baseUrl . '/files/';
		$options['rootAlias'] = 'Files';
		
		$this->options = array_merge($this->options,$options);
		
		$fileManager = new elFinder($this->options);
		$fileManager->run();
	}
	
	public function __set($propName, $propValue)
	{
		$this->options[$propName] = $propValue;
	}
	
	public function __get($propName)
	{
		if (array_key_exists($propName, $this->options)) {
			return $this->options[$propName];
		} else {
			return null;
		}
	}
}
