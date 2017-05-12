<?php

Yii::import('users.models.User');

class WebUser extends CWebUser
{
    private $_model = null;

    public function getRole()
    {
        if ($this->id == 'root') {
            return 'root';
        } elseif ($user = $this->getModel()) {
            if (!empty($user['role']))
                return $user['role'];
            else
                return 'user';
        }

        return 'guest';
    }

    public function getModel()
    {
        if ( ! $this->isGuest AND $this->_model === null) {
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
    }

    /*public function getReturnUrl($defaultUrl = '/')
    {
        if ($this->hasFlash('__returnUrl'))
            return $this->getFlash('__returnUrl');
        else
            return $defaultUrl;
    }

    public function setReturnUrl($value) {
        $this->setFlash('__returnUrl', $value);
    }*/
}

