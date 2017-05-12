<?php

class AdminController extends EAdminController
{
    public $menu;
    public $pageDescription;
    public $categories;
    protected $withCategories = false;

	public function getPageCaption()
    {
        return 'Новости';
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->categories = NewsCategory::model()->findAll();

        $this->menu = array();

        if (!$this->categories) {
            $this->menu[] = array(
                'label' => 'Новости',
                'icon' => 'th-list',
                'url' => array('/news/admin/index'),
            );
        }

        $this->menu[] = array(
            'label' => 'Добавить новость',
            'icon' => 'plus',
            'url' => array('/news/admin/create',
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
                'url' => array('/news/admin/index', 'category_id'=>0),
            );

            foreach ($this->categories as $category) {
                $this->menu[] = array(
                    'label' => $category->title,
                    'icon' => 'th-list',
                    'url' => array('/news/admin/index', 'category_id'=>$category->id),
                );
            }

            $this->menu[] = array(
                'label' => 'Список разделов',
                'icon' => 'th-large',
                'url' => array('/news/admin/categories'),
            );
        }

        if($this->withCategories || $this->categories){
            $this->menu[] = array(
                'label' => 'Добавить раздел',
                'icon' => 'plus-sign',
                'url' => array('/news/admin/createCategory'),
            );            
        }

        return true;
    }

    public function actionIndex($category_id=0)
    {
        $category = EArray::find($this->categories, 'id', $category_id);
        $dataProvider = new CActiveDataProvider('NewsItem', array(
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
                $this->clips['title'] = 'Новости без категории';
            } else {
                $this->clips['title'] = $category->title;
            }

            $dataProvider->criteria->addCondition('category_id=:category_id');
            $dataProvider->criteria->params[':category_id'] = $category_id;
        } else {
            $this->clips['title'] = 'Новости';
        }

		$this->pageTitle = 'Список новостей';
        $this->breadcrumbs = array(
            'Новости',
        );

        $this->render('index', array(
            'category' => $category,
            'dataProvider' => $dataProvider,
            'statuses' => NewsItem::getTimeStatusList(),
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
		$model = new NewsItem();
        if ($this->withCategories) {
            $model->category_id = $category_id;
        } else {
            $model->category_id = 0;
        }
        
        if (isset($_POST['NewsItem'])) {
            $model->attributes = $_POST['NewsItem'];
            $model->author_id = Yii::app()->user->id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Новость создана успешно.');
                if ($this->withCategories) {
					$this->redirect(array('index', 'category_id'=>$model->category_id));
                } else {
					$this->redirect(array('index'));
                }
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($model));
            }
        }

        $this->pageTitle = 'Создание новости';
		$this->pageDescription = 'Создание новости';

        $this->clips['content_title']= 'Создание новости';

        $this->breadcrumbs = array(
            'Новости' => array('index'),
            'Создание'
        );

        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id)
    {
        $this->pageTitle = 'Изменение новости';
		$this->pageDescription = 'Изменение новости';
        $this->clips['content_title']= 'Изменение новости';
		$model = $this->loadModel($id);

        if (isset($_POST['NewsItem'])) {
            $model->attributes = $_POST['NewsItem'];
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
            Yii::app()->user->setFlash('success', 'Новость удалена успешно.');
            if ($this->withCategories) {
                $this->redirect(array('index', 'category_id'=>$category_id));
            } else {
                $this->redirect(array('index'));
            }
        }
    }

    public function actionCategories()
    {
        $dataProvider = new CActiveDataProvider('NewsCategory');

        //$this->title = 'Новостные разделы';

        $this->render('categories', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreateCategory()
    {
        $model = new NewsCategory();

        if (isset($_POST['NewsCategory'])) {
            $model->attributes = $_POST['NewsCategory'];

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
        $model = NewsCategory::model()->findByPk($id);

        if (isset($_POST['NewsCategory'])) {
            $model->attributes = $_POST['NewsCategory'];

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

        $model = NewsCategory::model()->findByPk($id);
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
        $model = NewsItem::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404);
        }

        return $model;
    }
}
