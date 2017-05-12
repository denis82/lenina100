<?php

class AdminController extends EAdminController
{
    public $layout = 'admin';
    
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
            return false;
        
        $modelName = isset($_GET['model']) ? $_GET['model'] : 'contacts';
        $this->menu = array();

        $this->menu[] = array(
            'label' => 'Обратная связь',
            'url' => array('/configs/admin/index', 'model'=>'contacts'),
            'icon' => 'pencil',
            'active' => $modelName=='contacts',
        );

        $this->menu[] = array(
            'label' => 'Вопрос-ответ',
            'url' => array('/configs/admin/index','model'=>'faq'),
            'icon' => 'question-sign',
            'active' => $modelName=='faq',
        );
		
		$this->menu[] = array(
            'label' => 'Запись на приём',
            'url' => array('/configs/admin/index','model'=>'appointment'),
            'icon' => 'pencil',
            'active' => $modelName=='appointment',
        );
        return true;
    }

    public function actionIndex($model='contacts')
    {
        $configForm = new ConfigForm;

        if (isset($_POST['ConfigForm'])) {
            $configForm->attributes = $_POST['ConfigForm'];

            if ($configForm->validate()) {
                Yii::app()->user->setFlash('success', 'Изменения сохранены успешно.');
                $configForm->save();
                $this->refresh();
            }
        }

        $this->pageTitle = 'Уведомления сайта';
        $this->breadcrumbs = array(
            'Уведомления',
        );
        $this->render($model, array(
            'configForm' => $configForm,
        ));
    }
}