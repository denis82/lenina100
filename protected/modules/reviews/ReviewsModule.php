<?php

class ReviewsModule extends CWebModule 
{
    public $label = 'Отзывы';

    public function init() {
        $this->setImport(array(
            'reviews.models.*',
            'reviews.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (!parent::beforeControllerAction($controller, $action))
            return false;

        return true;
    }

}
