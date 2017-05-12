<?php

class NewsModule extends CWebModule
{
    public $label = 'Новости';
    
    public function init()
    {
        $this->setImport(array(
            'news.models.*',
            'news.components.*',
            'news.extensions.feed.*',
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
