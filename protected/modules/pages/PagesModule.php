<?php

class PagesModule extends CWebModule 
{
    public $label = 'Страницы';
    
    public function init() 
    {
        $this->setImport(array(
            'pages.models.*',
            'pages.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) 
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        }
        else
            return false;
    }

}
