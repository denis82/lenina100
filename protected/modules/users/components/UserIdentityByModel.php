<?php

Yii::import('users.models.User');

class UserIdentityByModel extends CUserIdentity
{

    public $model;
    protected $_id;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
    
    public function authenticate() {
        $username = strtolower($this->username);

        if ($this->model!==null) {
            
            $this->_id = $this->model->id;
            $this->username = trim($this->model->name);
            
            $this->errorCode = self::ERROR_NONE;
            
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }

        return $this->errorCode === self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}

