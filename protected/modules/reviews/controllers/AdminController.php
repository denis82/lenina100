<?php

class AdminController extends EAdminController
{
    public $menu;

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x02A353,
                'transparent' => true,
            ),
        );
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
            return false;

        $this->menu = array();

        $categoriesMenu = array(
            array(
                'label' => 'Все',
                'url' => array('/reviews/admin/index', 'catId' => 0),
            )
        );

        // Собираем категории
        $categories = FaqCategory::model()->findAll();
        foreach ($categories as $category) {
            $categoriesMenu[] = array(
                'label' => $category->title,
                'url' => array('/faq/admin/index', 'catId' => $category->id),
            );
        }

        $this->menu[] = array(
            'label' => 'Отзывы',
            'itemOptions' => array('class' => 'nav-header'),
        );
        $this->menu[] = array(
            'label' => 'Ждут ответа',
            'url' => array('/reviews/admin/index'),
            'icon' => 'question-sign',
            'active' => $action->id=='index' AND !isset($_GET['catId']),
        );

        $this->menu[] = array(
            'label' => 'Все отзывы',
            'icon' => 'icon-plus',
            'url' => array('/reviews/admin/index', 'catId' => 0),
            //'items' =>$categoriesMenu,
        );

        $this->menu[] = array(
            'label' => 'Создать отзыв',
            'icon' => 'icon-plus',
            'url' => array('/reviews/admin/create'),
        );

//         $this->menu[] = array(
//             'label' => 'Настройки',
//             'itemOptions' => array('class' => 'nav-header'),
//         );
//         $this->menu[] = array(
//             'label' => 'Создать раздел',
//             'icon' => 'folder-open',
//             'url' => array('/faq/admin/newCategory'),
//         );

//         if(count($categoriesMenu) > 1){
//             $this->menu[] = array(
//                 'label' => 'Изменить разделы',
//                 'icon' => 'pencil',
//                 'url' => array('/faq/admin/category'),
//             );
//         }

        return true;
    }


    public function actionIndex()
    {
        $this->pageTitle = 'Отзывы - разделы';
		$this->clips['content_title']= 'Отзывы - разделы';

		if (isset($_GET['catId'])) {
		    $category_id = $_GET['catId'];
            if(!$category_id){
                $criteria = new CDbCriteria;
               // $criteria->condition = 'category_id = 0';

                $title = 'Без раздела';
            }else{
                //$category = FaqCategory::model()->findByPk($category_id);
//                 if(!$category){
//                     throw new CHttpException(404);
//                 }else{
                    $criteria = new CDbCriteria;
                    $criteria->condition = 'category_id = :categoryId';
                    $criteria->params = array(
                        ':categoryId' => $category_id,
                    );
                   // $title = $category->title;
                //}
            }
	    
            $dataProvider = new CActiveDataProvider('Reviews', array(
                'criteria' => $criteria,
            ));
            $this->breadcrumbs = array(
                'Отзывы' => array('index'),
                $title,
            );
        } else {
	   //var_dump(Reviews::model()->findAll());
            $dataProvider = new CActiveDataProvider(Reviews::model()->waiting());
            $this->breadcrumbs = array(
                'Отзывы',
            );
        }

        if (isset($_POST['Reviews'])) {
	    //echo '<pre>'; var_dump($dataProvider->data);die(); echo '</pre>';
            foreach ($_POST['Reviews'] as $i=>$item) {
		$item = Reviews::model()->findByPk($i);
                if (isset($item->id)) {
                    $item->status = $_POST['Reviews'][$item->id]['status'];
                    if (isset($_POST['Reviews'][$item->id]['weight'])) {
                        $item->weight = $_POST['Reviews'][$item->id]['weight'];
                        $item->visible = $_POST['Reviews'][$item->id]['visible'];
                    }
                     $item->save();
                 }
            }
            Yii::app()->user->setFlash('success', 'Изменения сохранены.');
            $this->refresh();
        }

        $dataProvider->pagination->pageSize = 0;
        $dataProvider->sort->defaultOrder = 'create_time DESC';

        //$this->title = isset($category) ? $category->title : "Новые вопросы";

        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }
		
//     public function actionNewCategory()
//     {
//         $this->pageTitle = 'Создание нового раздела';
// 
// 		$this->clips['content_title']= 'Создание нового раздела';
// 
// 		$model = new FaqCategory;
//         if (isset($_POST['FaqCategory'])) {
//             $model->attributes = $_POST['FaqCategory'];
// 
//             if ($model->save()) {
//                 Yii::app()->user->setFlash('success', 'Раздел успешно создан.');
//                 $this->redirect($this->createUrl('category'));
//             }
//         }
// 
//         //$this->title = 'Создание нового раздела';
// 
//         $this->breadcrumbs = array(
//             'Вопрос-ответ' => array('index'),
//             'Создание раздела',
//         );
//         $this->clips['title'] = 'Создание раздела';
//         $this->render('categoryForm', array('model' => $model));
//     }

    public function actionCategory()
    {
        $this->pageTitle = 'Просмотр и редактирование категорий';

		if (isset($_POST["FaqCategory"])) {
            $this->updateCategories();
            $this->refresh();
        }

        $dataProvider = new CActiveDataProvider('FaqCategory', array(
            'sort' => array(
                'defaultOrder' => 'weight DESC'
            )
        ));

        //$this->title = 'Разделы';

        $this->breadcrumbs = array(
            'Отзывы' => array('index'),
            'Разделы',
        );
        $this->render('category', array(
            'dataProvider' => $dataProvider
        ));
    }

//     public function updateCategories()
//     {
//         $this->pageTitle = 'Изменение категории';
// 
// 		$this->clips['content_title']= 'Изменение категории';
// 		foreach($_POST['FaqCategory'] as $id=>$attributes) {
//             $model = FaqCategory::model()->find("id = :id", array(":id"=>$id));
// 
//             if (!$model)
//                 continue;
// 
//             $model->attributes = $_POST['FaqCategory'][$id];
// 
//             if ($model->save()) {
//                 Yii::app()->user->setFlash('success', 'Изменения успешно сохранены.');
//             }
//         }
//     }

//     public function actionDeleteCategory()
//     {
// 
//         if (!Yii::app()->request->isPostRequest || !isset($_GET['catId'])){
//             throw new CHttpException(400);
//         }
// 
//         $model = FaqCategory::model()->findByPk($_GET['catId']);
// 
//         if ($model->delete()) {
//             Yii::app()->user->setFlash('success', 'Категория успешно удалена.');
//         }
// 
//         $this->redirect(Yii::app()->request->urlReferrer);
//     }

    public function actionCreate()
    {
		$model = new Reviews();
        $model->category_id = isset($_GET['categoryId']) ? $_GET['categoryId'] : 0;

        if (isset($_POST['Reviews'])) {
            $model->scenario = 'create';
            $model->attributes = $_POST['Faq'];
            if ($model->save()) {
			    Yii::app()->user->setFlash('success','Отзыв создан успешно.');
                $this->redirect(array('index', 'catId' => $model->category_id));
			}
        }

        $this->pageTitle = 'Создание отзыва';
        $this->breadcrumbs = array(
            'Отзывы' => array('index'),
            'Создание Отзыва',
        );
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate()
    {
	
        $this->pageTitle = 'Редактирование отзыва';
		$this->clips['content_title']= 'Редактирование отзыва';
		if (!isset($_GET['id']))
            die();

        $model = Reviews::model()->findByPk($_GET['id']);
        if (isset($_POST['Reviews'])) {
            $model->scenario = 'update';
            $model->attributes = $_POST['Reviews'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Изменения успешно сохранены.');
                $this->redirect(array('index'));
            }
        }

        $this->breadcrumbs = array(
            'Отзывы' => array('index'),
            'Редактирование вопроса',
        );
        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionDelete()
    {
		if (!isset($_GET['id'])) {
            throw new CHttpException(404, 'Ошибка обработки запроса.');
        }

        $model = Reviews::model()->findByPk($_GET['id']);
        if ($model !== null) {

            if ($model->delete()) {
                Yii::app()->user->setFlash('success', 'Отзыв удален успешно.');
			}
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }
}
