<?php

class FilemanagerModule extends CWebModule
{
    public $label = 'Файлы';
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
                    
		// import the module-level models and components
		$this->setImport(array(
			'filemanager.models.*',
			'filemanager.components.*',
			'filemanager.extensions.elfinder.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
                        if(isset($_POST['YII_CSRF_TOKEN']) && !empty($_POST['YII_CSRF_TOKEN'])
                                && isset($_POST['PHPSESSID']) && !empty($_POST['PHPSESSID']))
                        {
                            $_COOKIE['YII_CSRF_TOKEN'] = $_POST['YII_CSRF_TOKEN'];
                            $_COOKIE['PHPSESSID'] = $_POST['PHPSESSID'];
                        }
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
