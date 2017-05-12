<?php

class LoginForm extends CFormModel
{

    public $email;
    public $password;
    public $notRememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('email', 'required'),
            
            // rememberMe needs to be a boolean
            array('notRememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate', 'skipOnError' => true),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email' => 'E-mail',
            'password' => 'Пароль',
            'notRememberMe' => 'Чужой компьютер',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        $this->_identity = new UserIdentity($this->email, $this->password);
        if (!$this->_identity->authenticate()) {
            if ($this->_identity->errorCode == UserIdentity::ERROR_USERNAME_INVALID) {
                $this->addError('password', 'Нет пользователя с таким E-mail');
            } elseif ($this->_identity->errorCode == UserIdentity::ERROR_PASSWORD_INVALID) {
                $this->addError('password', 'Неверный пароль');
            } else {
                $this->addError('password', 'Неверный пользователь или пароль.');
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->email, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = 3600 * 24 * 30; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }

}

