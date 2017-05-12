<?php

class WUserPortlet extends CWidget
{
    public function run()
    {
        $webUser = Yii::app()->user;
        if ($webUser->isGuest) {
            Yii::import('users.models.LoginForm');
            $form = new LoginForm();
            if (isset($_POST['LoginForm'])) {
                $form->attributes = $_POST['LoginForm'];
            }

            $this->render('guest_portlet', array(
                'form' => $form,
            )); 
        } else {
            $user = Yii::app()->user->getModel();

            $this->render('user_portlet', array(
                'user' => $user,
            ));
        }
    }
}

