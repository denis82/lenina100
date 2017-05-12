<?php

class ContactForm extends CFormModel {

    public $name;
    public $phone;
    public $email;
    public $subject;
    public $message;
    
    public function rules() {
        return array(
            array('email, message', 'required',
                'message' => 'Не заполнено поле {attribute}'),
            array('name, phone, subject', 'length','max' => 255),
            array('message', 'length','max' => 65535),
            array('email', 'email', 'allowEmpty' => false),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => 'Имя',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'subject' => 'Тема сообщения',
            'message' => 'Сообщение',
        );
    }

    public function send($validate = true)
    {
        if ($validate AND ! $this->validate()){
            return false;
        }

       return Yii::app()->mailManager->send(array(
            'to' => Yii::app()->config->get('adminEmail'),
            'model'=>$this,
            'message'=>$this->message,
            'pattern'=>'contactEmailTemplate',
        ));
    }
}
?>