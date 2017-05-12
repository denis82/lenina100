<?php

class DefaultController extends Controller
{
    public $defaultAction = '/profile';
    public $layout = '//layouts/login'; 
    
    public function init()
    {
        parent::init();

        // Устанавливаем перенаправление
        if(isset($_SERVER['HTTP_REFERER'])){
            $referer = array_pop(explode('/', $_SERVER['HTTP_REFERER']));
            // возвращаем обратно после логина, если пользователь в процессе заказа
            if(
                $referer == 'order' ||
                $referer == 'cart'
            ){
                $this->defaultAction = $_SERVER['HTTP_REFERER'];
            }else if(
            // перенаправляем на страницу управления, если пользователь админ
                in_array(Yii::app()->user->role, array('root', 'admin'))
                && $referer != 'profile'
            ){
                $this->defaultAction = '/admin';
            }
        }
    }

    /**
     * Регистрация
     */
    public function actionRegistration()
    {
        $model = new RegistrationForm();
        $class = get_class($model);

        if (isset($_POST[$class])) {
            $model->attributes = $_POST[$class];
            if ($model->save()) {
                Yii::app()->user->setFlash('registration', 'Спасибо за регистрацию');
                if ($model->login()) {
                    $this->redirect(array('/users/default/view'));
                } else {
                    $this->refresh();
                }
            }
        }

        $this->breadcrumbs = array(
            'Регистрация',
        );
        $this->render('registration', array(
            'model' => $model,
        ));
    }

    /**
     * Просмотр профиля пользователя
     */
    public function actionView($id=null)
    {
        $uid = Yii::app()->user->id;

        if(!$uid){
            $this->redirect('/');
        }else if(!$id){
            $id = $uid;
        }

        $model = User::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404);
        }

        $accessModel = AuthItemForm::getById($model->role);

        if (Yii::app()->user->model !== null && Yii::app()->user->model->id == $model->id) {
            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];
                if ($model->save()) {
                    Yii::app()->user->setFlash('users.default.view', 'Сохранено');
                    $this->refresh();
                }
            }
        }

        if (Yii::app()->user->isGuest) {
            $this->breadcrumbs = array(
                'Профиль пользователя',
            );
        } else {
            $this->breadcrumbs = array(
                'Ваш профиль',
            );
        }

        $this->render('view', array(
            'model' => $model,
            'access'=> $accessModel
        ));
    }

    /**
     * Обновление пароля
     */
    public function actionChangePassword()
    {
        $this->pageTitle = 'Смена пароля';

        $user = Yii::app()->user->getModel();
        if ($user === null) {
            throw new CHttpException(404);
        }

        $model = new ChangePasswordForm($user);
        if ($user->getPassword() != '') {
            $model->scenario = 'changePassword';
        }

        if (isset($_POST['ChangePasswordForm'])) {
            $model->attributes = $_POST['ChangePasswordForm'];
            if ($model->validate()) {
                $model->saveNewPassword();

                Yii::app()->user->setFlash('changePassword', 'Пароль успешно сменен.');
                $this->refresh();
            }
        }

        $this->render('changePassword', array(
            'model' => $model,
        ));
    }

    /**
     * Вход
     */
    public function actionLogin()
    {
        $this->pageTitle = 'Вход';
        if(Yii::app()->user->id){
            $this->redirect($this->defaultAction);
        }

        $service = Yii::app()->request->getQuery('service');
        if (isset($service)) {
            $authIdentity = Yii::app()->eauth->getIdentity($service);

            if (Yii::app()->user->hasState('returnUrl')) {
                $authIdentity->redirectUrl = Yii::app()->user->getState('returnUrl');
            } else {
                $authIdentity->redirectUrl = array('/users/default/view');
            }
            $authIdentity->cancelUrl = $this->createAbsoluteUrl('users/default/login');

            if ($authIdentity->authenticate()) {
                $identity = new ServiceUserIdentity($authIdentity);
                // Успешный код
                if ($identity->authenticate()) {
                    if (Yii::app()->user->isGuest) {
                        $duration = 3600 * 24 * 30; // 30 days
                        Yii::app()->user->login($identity, $duration);
                    }

                    // Специальный редирект с закрытием popup окна
                    $authIdentity->redirect();
                    //$this->forward('authRedirect');
                } else {

                    // Закрывает popup окно и перенаправляем на cancelurl
                    $authIdentity->cancel();
                    //$this->forward('authCancel');
                }
            }
        }

        $loginForm = new LoginForm();

        if (isset($_POST['LoginForm'])) {
            $loginForm->attributes = $_POST['LoginForm'];
            if ($loginForm->validate()) {
                $loginForm->login();
            }
        }

        if(Yii::app()->user->id){
            $this->redirect('login');
        }

        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = false;
        }

        $this->breadcrumbs = array(
            'Вход',
        );

        $this->render('login', array(
            'loginForm' => $loginForm,
        ));
    }

    /**
     * Выход
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->end(200);
        } else {
            if (!empty(Yii::app()->request->urlReferrer)) {
                $this->redirect(Yii::app()->request->urlReferrer);
            } else {
                $this->redirect('/');
            }
        }
    }

    //////////////////////////////////////////////////////////////////
    /*
     * Функционал по восстановление пароля
     * Схема работы:
     * - пользователь заходит по ссылке forgetPassword, вводит свой e-mail
     * - на его электронну почту приходит письмо со ссылкой на authByCode,
     *   по которой он попадает на страницу, в которой вводит новый пароль.
     *   И сразу происходит процесс аутентификации.

    /**
     * Забыли пароль
     */
    public function actionForgetPassword()
    {
        $this->pageTitle = 'Забыли пароль?';
        $recoveryForm = new RecoveryForm();

        if (isset($_POST['RecoveryForm'])) {
            $recoveryForm->attributes = $_POST['RecoveryForm'];
            if ($recoveryForm->validate()  ) {

                $user = User::model()->findByAttributes(array('email'=>$recoveryForm->email));
                if ($user !== null) {
                    $mailer = Yii::app()->mailer;
                    $mailer->ClearAddresses();

                    $mailer->FromName = Yii::app()->name;
                    $mailer->From = Yii::app()->config->get('adminEmail');
                    $mailer->CharSet = 'utf8';

                    $subject = Yii::app()->config->get('recoveryMailTemplateSubject');
                    $mailer->Subject = !empty($subject) ? $subject : 'Смена пароля на сайте '.Yii::app()->name;

                    $content = Yii::app()->config->get('recoveryMailTemplate');
                    if (empty($content)) {
                        $content = ' {infoAboutRecovery} ';
                    }
                    $code = $this->generateRecoveryAuthCode($user);
                    if ($code === null) {
                        $infoAboutRecovery = 'Вы заходили на наш сайт через социальные сети ';
                        $authServices = $user->authServices;
                        $s = array();
                        foreach ($authServices as $service) {
                            $s[] = $service->serviceName;
                        }
                        if (!empty($s)) {
                            $infoAboutRecovery .= ' (' . implode(',', $s) . ')';
                        }
                    } else {
                        $infoAboutRecovery = 'Перейдите по ссылке: ' .
                                                $this->createAbsoluteUrl('changeForgetedPassword', array('i'=>$user->id,'c'=>$code));
                    }

                    $mailer->Body = strtr($content, array(
                        '{infoAboutRecovery}' => $infoAboutRecovery,
                    ));
                    $mailer->AddAddress($user->email);
                    if ($mailer->Send()) {
                        Yii::app()->user->setFlash('forgetPassword', 'Посмотрите письмо по указанному адресу электронной почты.');
                    } else {
                        Yii::app()->user->setFlash('forgetPassword', 'Ошибка. Письмо не отправлено.<br />' . $mailer->ErrorInfo);
                    }
                } else {
                    Yii::app()->user->setFlash('forgetPassword', 'Пользователь с таким адресом не зарегистрирован на сайте.');
                }

                $this->refresh();
            }
        }

        $this->render('forgetPassword', array(
            'recoveryForm' => $recoveryForm,
        ));
    }

    /**
     * Смена забытого пароля
     */
    public function actionChangeForgetedPassword($i, $c)
    {
        $user = Yii::app()->identityMap->loadModel('User', $i);
        $code = $this->generateRecoveryAuthCode($user);
        if ($code == null || $code!=$c) {
            $this->redirect(array('/error'));
            //throw new CHttpException(404, 'Данной страницы больше не существует.');
        }

        $changePasswordForm = new ChangePasswordForm($user);
        if (isset($_POST['ChangePasswordForm'])) {
            $changePasswordForm->attributes = $_POST['ChangePasswordForm'];
            if ($changePasswordForm->validate()) {
                $changePasswordForm->saveNewPassword();

                $loginForm = new LoginForm();
                $loginForm->email = $user->email;
                $loginForm->password = $changePasswordForm->password;
                if ($loginForm->validate() && $loginForm->login()) {
                    Yii::app()->user->setFlash('changePassword', array('message' => 'Пароль успешно сменен.'));
                    $this->redirect('/');
                } else {
                    echo CHtml::errorSummary($loginForm);
                    $this->redirect('login');
                }
            }
        }

        $this->render('changeForgetedPassword', array(
            'changePasswordForm' => $changePasswordForm,
        ));
    }

    protected function generateRecoveryAuthCode(User $user)
    {
        $email = $user->email;
        $password = $user->password;

        if (empty($email) || empty($password)) {
            return null;
        }

        // Ссылка будет актуальна сутки
        $timestamp = mktime(0, 0, 0);

        return sha1($email.$password.$timestamp);
    }
}

