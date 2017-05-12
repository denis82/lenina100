<?php

class UpdateProfileForm extends User
{
    public function rules()
    {
        return array(
            array('name', 'length', 'max' => 255),
            array('email', 'email'),
            array('email', 'unique'),
        );
    }

    public function attributeLabels()
    {
        return parent::attributeLabels();
    }

    public function afterFind()
    {
        parent::afterFind();
    }
}
