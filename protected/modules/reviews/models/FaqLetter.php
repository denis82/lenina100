<?php

/**
 * Конфигурация WebMoney
 */
class FaqLetter extends CFormModel
{
    public $faqUserEmailTemplate;
    public $faqAdminEmailTemplate;
    
    public function rules()
    {
        return array(
            array('faqUserEmailTemplate, faqAdminEmailTemplate', 'safe')
        );
    }

    public function attributeLabels()
    {
        return array(
            'faqUserEmailTemplate' => 'Шаблон письма пользователю',
            'faqAdminEmailTemplate'=> 'Шаблон письма администратору',
            
        );
    }

    public function save()
    {
        $attributes = $this->getAttributes();
        foreach ($attributes as $name => $value) {
            Yii::app()->config->set($name, $value);
        }

        return true;
    }

    protected function afterConstruct()
    {
        parent::afterConstruct();

        $attributes = $this->getAttributes();
        foreach ($attributes as $name => $value) {
            $this->{$name} = Yii::app()->config->get($name);
        }
    }
    
    protected function getConfigs()
    {
        return array(
            'common' => array('title' => 'Общие', 'test' => array()),
            'test'   => array(),
        );
    }
}

