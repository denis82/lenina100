<?php

class ConfigsModule extends CWebModule
{
    public $label = 'Уведомления';
    
    public function init()
    {
        $this->setImport(array(
                'configs.models.*',
                'configs.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            return true;
        }
        else
            return false;
    }
}

