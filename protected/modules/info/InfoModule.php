<?php

class InfoModule extends CWebModule
{
    public $label = 'Справочник';
    
    public function init()
    {
        $this->setImport(array(
            'info.models.*',
            'info.components.*',
            'info.extensions.feed.*',
            'users.models.User',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action))
        {
            return true;
        }
        else
            return false;
    }

}
