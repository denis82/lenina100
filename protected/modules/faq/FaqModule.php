<?php

class FaqModule extends CWebModule 
{
    public $label = 'Вопрос-ответ';

    public function init() {
        $this->setImport(array(
            'faq.models.*',
            'faq.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (!parent::beforeControllerAction($controller, $action))
            return false;

        return true;
    }

}
