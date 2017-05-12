<?php

class RegistrationForm extends User
{
    // Повтор пароля
    public $password_repeat;

    public function rules()
    {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'unique'),
            array('name', 'length', 'max' => 255),
            array('password', 'compare'),
            array('password_repeat', 'safe'),            
        );
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            array(
                'password_repeat' => 'Повтор пароля',
            )
        );
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->password = $this->hashPassword($this->password);

            return true;
        }

        return false;
    }

    protected function afterValidate()
    {
        parent::afterValidate();

        if ($this->hasErrors()) {
            $this->password = null;
            $this->password_repeat = null;
        }
    }

    protected function beforeFind()
    {
        parent::beforeFind();

        throw new CException('Ошибка');
    }

    public function login()
    {
        $identity = new UserIdentityByModel($this);
        if ($identity->authenticate()) {
            $duration = 3600 * 24 * 30;
            Yii::app()->user->login($identity, $duration);

            return true;
        }

        return false;
    }
}
