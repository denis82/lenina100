<?php

class AdminController extends EAdminController
{
    public $menu;
    public $pageDescription;
    public $categories;
    protected $withCategories = false;

	public function getPageCaption()
    {
        return 'Справочник';
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->categories = InfoCategory::model()->findAll();

        $this->menu = array();

        if (!$this->categories) {
            $this->menu[] = array(
                'label' => 'Справочник',
                'icon' => 'th-list',
                'url' => array('/info/admin/index'),
            );
        }

        $this->menu[] = array(
            'label' => 'Добавить статью',
            'icon' => 'plus',
            'url' => array('/info/admin/create',
                'category_id'=>isset($_GET['category_id']) ? $_GET['category_id'] : 0),
        );

        if ($this->categories) {
            $this->menu[] = array(
                'label' => 'Разделы',
                'itemOptions' => array('class' => 'nav-header'),
            );
            $this->menu[] = array(
                'label' => 'Без раздела',
                'icon' => 'th-list',
                'url' => array('/info/admin/index', 'category_id'=>0),
            );

            foreach ($this->categories as $category) {
                $this->menu[] = array(
                    'label' => $category->title,
                    'icon' => 'th-list',
                    'url' => array('/info/admin/index', 'category_id'=>$category->id),
                );
            }

            $this->menu[] = array(
                'label' => 'Список разделов',
                'icon' => 'th-large',
                'url' => array('/info/admin/categories'),
            );
        }

        if($this->withCategories || $this->categories){
            $this->menu[] = array(
                'label' => 'Добавить раздел',
                'icon' => 'plus-sign',
                'url' => array('/info/admin/createCategory'),
            );            
        }

        return true;
    }

    public function actionIndex($category_id=0)
    {
        $category = EArray::find($this->categories, 'id', $category_id);
        $dataProvider = new CActiveDataProvider('InfoItem', array(
            'sort' => array(
                'defaultOrder' => 'create_time DESC',
            ),
        ));

        if (isset($_GET['filter'])) {
            $dataProvider->criteria->params[':time'] = time();
            switch (urldecode($_GET['filter'])) {
                case 'past':
                    $dataProvider->criteria->addCondition('expire_time > 0 AND expire_time < :time');
                    break;
                case 'present':
                    $dataProvider->criteria->addCondition('(expire_time = 0 OR expire_time >= :time) AND create_time <= :time');
                    break;
                case 'future':
                    $dataProvider->criteria->addCondition('create_time > :time');
                    break;
                case 'all':
                    unset($dataProvider->criteria->params[':time']);
            }
        }

        if ($this->withCategories) {
            if (!$category) {
                $this->clips['title'] = 'статьи без категории';
            } else {
                $this->clips['title'] = $category->title;
            }

            $dataProvider->criteria->addCondition('category_id=:category_id');
            $dataProvider->criteria->params[':category_id'] = $category_id;
        } else {
            $this->clips['title'] = 'Справочник';
        }

		$this->pageTitle = 'Список статей';
        $this->breadcrumbs = array(
            'Справочник',
        );

        $this->render('index', array(
            'category' => $category,
            'dataProvider' => $dataProvider,
            'statuses' => InfoItem::getTimeStatusList(),
        ));
    }

    public function actionArchive()
    {
        throw new CHttpException(403);

        $this->render('archive', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate($category_id=0)
    {
		$model = new InfoItem();
        if ($this->withCategories) {
            $model->category_id = $category_id;
        } else {
            $model->category_id = 0;
        }
        
        if (isset($_POST['InfoItem'])) {
            $model->attributes = $_POST['InfoItem'];
            $model->author_id = Yii::app()->user->id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Статья создана успешно.');
                if ($this->withCategories) {
					$this->redirect(array('index', 'category_id'=>$model->category_id));
                } else {
					$this->redirect(array('index'));
                }
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            }
        }

        $this->pageTitle = 'Создание статьи';
		$this->pageDescription = 'Создание статьи';

        $this->clips['content_title']= 'Создание статьи';

        $this->breadcrumbs = array(
            'Статья' => array('index'),
            'Создание'
        );

        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id)
    {
        $this->pageTitle = 'Изменение статьи';
		$this->pageDescription = 'Изменение статьи';
        $this->clips['content_title']= 'Изменение статьи';
		$model = $this->loadModel($id);

        if (isset($_POST['InfoItem'])) {
            $model->attributes = $_POST['InfoItem'];
            if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Изменения успешно сохранены.');
					if ($this->withCategories) {
						$this->redirect(array('index', 'category_id'=>$model->category_id));
                    } else {
						$this->redirect(array('index'));
                    }

				}
                else {
                    Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
					//$this->redirect(array('index'));
                }

        }

        $this->render('update', array(
            'model' => $model
        ));
    }

    public function actionDelete($id)
    {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(400);
        }

        $model = $this->loadModel($id);
        $category_id = $model->category_id;
        $model->delete();

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->user->setFlash('success', 'Статья удалена успешно.');
            if ($this->withCategories) {
                $this->redirect(array('index', 'category_id'=>$category_id));
            } else {
                $this->redirect(array('index'));
            }
        }
    }

    public function actionCategories()
    {
        $dataProvider = new CActiveDataProvider('InfoCategory');
        $this->render('categories', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreateCategory()
    {
        $model = new InfoCategory();

        if (isset($_POST['InfoCategory'])) {
            $model->attributes = $_POST['InfoCategory'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Категория создана успешно.');
                $this->redirect(array('index', 'category_id'=>$model->id));
            }
        }

        $this->render('createCategory', array(
            'model' => $model,
        ));
    }

    public function actionUpdateCategory($id)
    {
        $model = InfoCategory::model()->findByPk($id);

        if (isset($_POST['InfoCategory'])) {
            $model->attributes = $_POST['InfoCategory'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Категория изменена успешно.');
                $this->redirect(array('index', 'category_id'=>$model->id));
            }
        }

        $this->render('updateCategory', array(
            'model' => $model,
        ));
    }

    public function actionDeleteCategory($id)
    {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(400);
        }

        $model = InfoCategory::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404);
        }

        $model->delete();

        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->user->setFlash('success', 'Категория удалена успешно.');
            $this->redirect(array('index'));
        }
    }

    protected function loadModel($id)
    {
        $model = InfoItem::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404);
        }

        return $model;
    }
}
