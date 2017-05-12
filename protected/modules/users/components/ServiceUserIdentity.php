<?php 

Yii::import('users.models.*');

class ServiceUserIdentity extends UserIdentity
{
    const ERROR_NOT_AUTHENTICATED = 3;

    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function authenticate()
    {
        if ($this->service->isAuthenticated) {

            // Находим AuthService
            $authService = AuthService::model()->findByAttributes(array(
                'id' => $this->service->id,
                'servicename' => $this->service->serviceName,
            ));
            if ($authService===null) {
                // Значит пользователь еще не заходил под этим аккаунтом
                $authService = new AuthService();
                $authService->id = $this->service->id;
                $authService->servicename = $this->service->serviceName;
                if ($authService->save(false)!==true) {
                    throw new CHttpException(400);
                }
            }

            if (($user=Yii::app()->user->model)===null) {
                $user = $authService->user;
                if ($user===null) {
                    $email = $this->service->getAttribute('email');
                    if (!empty($email)) {
                        $user = User::model()->findByAttributes(array('email' => $email));
                    }
                    if ($user===null) {
                        // Здесь создаем пользователя
                        $user = new User();
                        $user->name = $this->service->getAttribute('name');
                        $user->role = 'user';
                        $user->email = $this->service->getAttribute('email');
                        ////////////////////////////////////////////////   
                        if ($authService->servicename == 'vkontakte') {
                            $user->avatar_url = $this->service->getAttribute('photo');
                        } elseif ($authService->servicename == 'twitter') {
                            $user->avatar_url = 'http://api.twitter.com/1/users/profile_image/'.$authService->id.'.json';
                        } elseif ($authService->servicename == 'facebook') {
                            $user->avatar_url = 'https://graph.facebook.com/'.$authService->id.'/picture';
                        }

                        if ($user->save(false)!==true) {
                            throw new CHttpException(400);
                        }
                    } else {
                        if (empty($user->avatar_url)) {
                            if ($authService->servicename == 'vkontakte') {
                                $user->avatar_url = $this->service->getAttribute('photo');
                            } elseif ($authService->servicename == 'twitter') {
                                $user->avatar_url = 'http://api.twitter.com/1/users/profile_image/'.$authService->id.'.json';
                            } elseif ($authService->servicename == 'facebook') {
                                $user->avatar_url = 'https://graph.facebook.com/'.$authService->id.'/picture';
                            }
                            $user->save(false);
                        }
                    }

                    $authService->user_id = $user->id;
                    $authService->save(false);
                } else {
                    if ($authService->servicename == 'vkontakte') {
                        $photo = $this->service->getAttribute('photo');
                        if (!empty($photo)) {
                            $user->avatar_url = $this->service->getAttribute('photo');
                            $user->save(false);
                        }
                    }
                }


                $this->_id = $user->id;
                $this->username = trim($user->name);

                $this->errorCode = self::ERROR_NONE;
            } else {
                $authService->user_id = $user->id;
                $authService->save(false);

                $this->errorCode = self::ERROR_NONE;
                return true;
            }

        } else {
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        }

        return !$this->errorCode;
    }
}
