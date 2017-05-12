<?php

Yii::import('users.models.User');

class UserIdentity extends CUserIdentity {

    protected $_id;

    public function authenticate() {
        $username = strtolower($this->username);

        if ($username === 'root' AND $this->password == Yii::app()->params['rootPassword']) {
            $this->_id = 'root';
            $this->username = trim('Администратор');
            $this->errorCode = self::ERROR_NONE;
        } else {
            $user = User::model()->find('LOWER(email)=?', array($username));
            if ($user === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else if (!$user->validatePassword($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->_id = $user['id'];
                $this->username = trim($user['name']);
                $this->errorCode = self::ERROR_NONE;
            }
        }

        return $this->errorCode === self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}

