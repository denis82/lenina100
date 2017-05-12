<?php

class AppointmentForm extends CFormModel {

  public $name;
	public $sex;
	public $born_date;
	public $phone;
	public $service;
	public $date;
	public $comment;
	public $sub;

    public function rules() {
        return array(
            array('name, sex, born_date, phone, service, comment', 'required',
                'message' => 'Не заполнено поле {attribute}'),
            array('name', 'length', 'max' => 255),
			array('sub', 'boolean'),
			array('service', 'safe'),
			//array('born_date, date', 'type', 'type' => 'date', 'dateFormat'=>Yii::app()->locale->dateFormat),
			array('born_date, date', 'length', 'max'=>255),
        );
    }

    public function attributeLabels() {
			return array(
				'name' => 'ФИО*',
				'sex' => 'Пол*',
				'born_date' => 'Дата рождения*',
				'phone' => 'телефон*',
				'service' => 'Направление*',
				'date' => 'Желаемое время*',
				'comment' => 'Комментарий*',
				'sub' => 'Разрешаю обработку моих данных*',
			);
    }

    public function send($validate = true)
    {
        if ($validate AND !$this->validate()){
            return false;
        }
		
        return Yii::app()->mailManager->send(array(
            'to' => Yii::app()->config->get('adminEmail'),
            'subject'=>'Создана новая заявка на приём '.Yii::app()->name,
            'model'=>$this,
            'pattern'=>'orderEmailTemplate',
        ));
    }
	
}
