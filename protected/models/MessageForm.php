<?php

class MessageForm extends CFormModel {

    public $name;
    public $email;
    public $message;

    public function rules() {
        return array(
            array('email, message, name', 'required',
                'message' => 'Не заполнено поле {attribute}'),
            array('name', 'length','max' => 255),
            array('email', 'email', 'allowEmpty' => false),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => 'ФИО*',
            'email' => 'E-mail*',
            'message' => 'Вопрос*',
        );
    }

    public function send($validate = true)
    {
        if ($validate AND !$this->validate()){
            return false;
        }
		Yii::import('faq.models.Faq');
		$faq = new Faq;
		$faq->name_q = $this->name;
		$faq->email = $this->email;
		$faq->quest = $this->message;
		
		return $faq->save();
    }
}
