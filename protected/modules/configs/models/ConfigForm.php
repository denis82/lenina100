<?php

class ConfigForm extends CFormModel
{
    public $adminEmail;
    public $contactEmailTemplate;
    public $messageEmailTemplate;
    public $orderEmailTemplate;
    public $faqUserEmailTemplate;
    public $faqAdminEmailTemplate;
    
    public function rules()
    {
        return array(
            // adminEmail
            array('adminEmail', 'required'),
            array('adminEmail', 'emailsValidator'),
            // contactForm шаблон письма
            array('contactEmailTemplate, messageEmailTemplate, orderEmailTemplate, faqUserEmailTemplate, faqAdminEmailTemplate', 'safe')
        );
    }

    public function attributeLabels()
    {
        return array(
            'adminEmail' => 'E-mail администратора сайта',
            'contactEmailTemplate' => 'Шаблон email о новом сообщении',
            'messageEmailTemplate' => 'Шаблон email о новом запросе',
            'orderEmailTemplate' => 'Шаблон email о новой заявке на приём к специалисту',
            'faqUserEmailTemplate' => 'Шаблон email пользователю об ответе на вопрос',
            'faqAdminEmailTemplate' => 'Шаблон email администратору о новом вопросе',
        );
    }
    
    public function emailsValidator($attribute, $params)
    {
        $emails = preg_split('/[\s,]+/', $this->{$attribute}, -1, PREG_SPLIT_NO_EMPTY);
        $ev = new CEmailValidator();
        $validEmails = array();
        foreach ($emails as $email) {
            if (!$ev->validateValue($email)) {
                $validEmails[] = $email;
            }
        }
        if (!empty($validEmails)) {
            $this->addError($attribute, implode(', ', $validEmails) . ' - неправильные адреса');
        }
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
            'common' => array('title' => 'Общие',
                              'test' => array()),
            'test'   => array(),
        );
    }
}

