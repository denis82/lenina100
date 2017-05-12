<?php

class BannerModule extends CWebModule
{
	public $label = 'Баннеры';
	
	public function init()
	{
		// this method is called when the module is being created

		// import the module-level models and components
		$this->setImport(array(
			'banner.models.*',
			'banner.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			return true;
		}
		else
			return false;
	}
}