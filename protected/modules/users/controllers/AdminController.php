<?php

class AdminController extends EAdminController
{
    public $layout = 'admin';

    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        
        if(Yii::app()->user->role != 'root') {
            $criteria->condition = 'role != :role';
            $criteria->params = array(':role' => 'root');
        }
        
        $dataProvider = new CActiveDataProvider('User', array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'create_time DESC'
            )
        ));

        $this->pageTitle = 'Список пользователей';
        $this->breadcrumbs = array(
            'Пользователи',
        );
        
        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
        ));
    }
    
    public function actionCreate()
    {
		$model = new User();
        
        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            if ($model->save())
            {
                Yii::app()->user->setFlash('success', 'Пользователь создан успешно.');
                if (!Yii::app()->request->isAjaxRequest)
                    $this->redirect(array('index'));
            }
        }
        
        $this->pageTitle = 'Создание пользователя';
        $this->breadcrumbs = array(
            'Пользователи' => array('index'),
            'Создание',
        );

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $this->pageTitle = 'Редактирование пользователя';
		$model = $this->loadModel($id);
        
        if($model->role == 'root' && Yii::app()->user->role != 'root') {
            throw new CHttpException(403);
        }

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Изменения сохранены успешно.');
                $this->redirect(array('index'));
            }
        }

        $this->breadcrumbs = array(
            'Пользователи' => array('index'),
            'Редактирование'
        ,);
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(404);
        }
        
        $model = $this->loadModel($id);
        if (Yii::app()->user->role != 'root' && $model->role == 'root') {
            throw new CHttpException(403);
        }
        
        if ($model->delete()) {
                /*
			    $this->setFlash('users', array('type'=>'success',
                    'message'=>'Пользователь удален успешно.')); */
            Yii::app()->user->setFlash('success', 'Пользователь удален успешно.');
        }

        if (!Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['returnUrl'])) {
                $this->redirect($_GET['returnUrl']);
            }
            else {
                $this->redirect(array('index'));
            }
        }
    }

    public function actionRoles()
    {
        $roles = Yii::app()->authManager->getRoles();
        $data = array();
        foreach ($roles as $role) {
            if ($role->name == 'root') continue;
            $data[] = array(
                'id' => $role->name,
                'description' => $role->description,
            );
        }
        $dataProvider = new CArrayDataProvider($data, array(
            'id' => 'roles',
            'pagination' => false,
            'sort' => false,
        ));

        $this->breadcrumbs = array(
            'Пользователи' => array('index'),
            'Роли',
        );

        $this->render('roles', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreateRole()
    {
        $model = new AuthItemForm();
        if (isset($_POST['AuthItemForm'])) {
            $model->attributes = $_POST['AuthItemForm'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Сохранено.');
                //$this->redirect('settings');
                $this->refresh();
            }
        }

        $this->breadcrumbs = array(
            'Пользователи' => array('index'),
            'Роли' => array('roles'),
            'Создание',
        );
        $this->render('createRole', array(
            'model' => $model,
        ));
    }

    public function actionUpdateRole($id)
    {
        $model = AuthItemForm::getById($id);
        if (isset($_POST['AuthItemForm'])) {
            $model->attributes = $_POST['AuthItemForm'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Сохранено.');
                //$this->redirect('settings');
                $this->refresh();
            }
        }

        $this->breadcrumbs = array(
            'Пользователи' => array('index'),
            'Роли' => array('roles'),
            'Редактирование',
        );
        $this->render('updateRole', array(
            'model' => $model,
        ));
    }

    public function actionDeleteRole($id)
    {
        $model = AuthItemForm::getById($id);
        $model->delete();

        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionLetters()
    {
        $this->breadcrumbs = array(
            'Пользователи' => array('index'),
            'Письма',
        );
        $this->render('letters', array(
        ));
    }

    protected function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404);
        }

        return $model;
    }

}
