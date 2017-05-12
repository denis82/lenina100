<?php
class AdminController extends EAdminController
{
    public function getPageCaption()
    {
        return 'Отделы';
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) return false;

        $this->menu = array(
            array(
                'label' => 'Отделы',
                'icon' => 'th-list',
                'url' => array('/expert/admin/index'),
            ),
            array(
                'label' => 'Добавить отдел',
                'icon' => 'plus-sign',
                'url' => array('/expert/admin/createExpert'),
            )
        );

        return true;
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Expert', array(
            'sort' => array(
                'defaultOrder' => 'create_time DESC',
            )
        ));

        $this->pageTitle = 'Список отделов';
        $this->clips['title'] = 'Отделы';
        $this->breadcrumbs = array(
            'Отделы',
        );

        $this->render('expertes', array('dataProvider' => $dataProvider));
    }
    
    public function actionIndexExpert($expert_id=null)
    {
        $expert = $this->loadExpert($expert_id);
        $criteria = new CDbCriteria;
        $criteria->addCondition('expert_id = :expert');
        $criteria->params[':expert'] = $expert['id'];
        $dataProvider = new CActiveDataProvider('ExpertItem', array(
                'criteria' => $criteria,
                'sort' => array(
                    'defaultOrder' => 'name ASC',
                )
            )
        );

        $this->pageTitle = 'Сотрудники';
        $this->clips['title'] = 'Сотрудники';
        $this->breadcrumbs = array(
            'Отделы' => array('index'),
            $expert->name,
        );
        $this->render('expert', array('dataProvider'=>$dataProvider,
                                       'expert'=>$expert));
    } 
    
    public function actionCreateExpert()
    {
        $model = new Expert;
        if (isset($_POST['Expert'])) {
            $model->attributes = $_POST['Expert'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Отдел создан успешно.');
                $this->redirect(array('index'));
            }
        }

        $this->pageTitle = 'Создание отдела';
        $this->clips['title'] = 'Создание отдела';
        $this->breadcrumbs = array(
            'Отделы' => array('index'),
            'Создание'
        );
        $this->render('expertForm', array('model'=>$model));
    }
    
    public function actionCreateItem($expert_id=null)
    {
        $expert = $this->loadExpert($expert_id);
        $model = new ExpertItem(ExpertItem::SCENARIO_CREATE);
        if (isset($_POST['ExpertItem'])) {
            $model->attributes = $_POST['ExpertItem'];
            $model->expert_id = $expert->id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Данные о сотруднике успешно добавлены.');
                $this->redirect(array('indexExpert', 'expert_id'=>$expert->id));
            }
        }

        $this->pageTitle = 'Добавление сотрудника';
        $this->clips['title'] = 'Добавление сотрудника';
        $this->breadcrumbs = array(
            'Отделы' => array('index'),
            $expert->name => array('indexExpert', 'expert_id'=>$expert->id),
            'Добавление сотрудника'
        );
        $this->render('itemForm', array('model'=>$model));
    }
    
    public function actionUpdateExpert($expert_id=null) 
    {
        $model = $this->loadExpert($expert_id);


        if (isset($_POST['Expert'])) {
            $model->attributes = $_POST['Expert'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Отдел сохранен успешно.');
                $this->redirect(array('index'));
            }
        }

        $this->pageTitle = 'Изменение отдела';
        $this->clips['title'] = 'Изменение отдела';
        $this->breadcrumbs = array(
            'Отделы' => array('index'),
            $model->name => array('indexExpert', 'expert_id'=>$model->id),
            'Изменение'
        );
        $this->render('expertForm', array('model'=>$model));
    }
    
    public function actionUpdateItem($item_id=null)
    {
        $model = $this->loadItem($item_id);
        $expert = $this->loadExpert($model->expert_id);
        if (isset($_POST['ExpertItem'])) {
            $model->attributes = $_POST['ExpertItem'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Данные о сотруднике успешно сохранены.');
                $this->redirect(array('indexExpert', 'expert_id'=>$model->expert_id));
            }
        }

        $this->pageTitle = 'Изменение данных о сотруднике';
        $this->clips['title'] = 'Изменение данных о сотруднике';
        $this->breadcrumbs = array(
            'Отделы' => array('index'),
            $expert->name => array('indexExpert', 'expert_id'=>$expert->id),
            'Изменение изображения'
        );
        $this->render('itemForm', array('model'=>$model, 'expert'=>$expert));
    }
    

    public function actionDeleteExpert($expert_id=null)
    {
        $model = Expert::model()->findByPk($expert_id);
        if($model->delete()){
            Yii::app()->user->setFlash('success', 'Отдел успешно удален.');
            $this->redirect(array('index'));
        }
    }
    
    public function actionDeleteItem($item_id=null) 
    {
        $model = $this->loadItem($item_id);
        if ($model->delete()) {
            Yii::app()->user->setFlash('success', 'Данные о сотруднике успешно удалены.');
      }
      
        $this->redirect(array('indexExpert', 'expert_id'=>$model->expert_id));
    }
    
    protected function loadExpert($id) 
    {
        $model = Expert::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404);
        }
        return $model;
    }
    
    protected function loadItem($id)
    {
        $model = ExpertItem::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404);
        }
        return $model;
    }
}
