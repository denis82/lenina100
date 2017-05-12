<?php

class ChangePasswordForm extends CFormModel
{
    protected $userModel;

    public $password;
    public $password_repeat;

    public $password_old;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function rules()
    {
        return array(
            array('password', 'required'),
            array('password', 'length', 'min' => 3, 'max' => 16),
            array('password_repeat', 'compare', 'compareAttribute' => 'password'),

            array('password_old', 'checkOldPassword', 'on' => 'changePassword'),
        );
    }

    public function checkOldPassword($attribute, $params)
    {
        if (!$this->userModel->validatePassword($this->{$attribute})) {
            $this->addError($attribute, 'Неверный старый пароль');
        }
    }

    public function attributeLabels()
    {
        return array(
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'password_old' => 'Старый пароль',
        );
    }

    public function saveNewPassword()
    {
        if ($this->validate() !== true) {
            return false;
        }

        $this->userModel->setPassword($this->password);

        return $this->userModel->save(false);
    }
}
