<?php
class AdminController extends EAdminController
{
    public function getPageCaption()
    {
        return 'Новости';
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) return false;

        $this->menu = array(
            array(
                'label' => 'Баннеры',
                'icon' => 'th-list',
                'url' => array('/banner/admin/index'),
            ),
            array(
                'label' => 'Добавить раздел баннеров',
                'icon' => 'plus-sign',
                'url' => array('/banner/admin/createBanner'),
            )
        );

        return true;
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Banner', array(
            'sort' => array(
                'defaultOrder' => 'create_time DESC',
            )
        ));

        $this->pageTitle = 'Список разделов баннеров';
        $this->clips['title'] = 'Баннеры';
        $this->breadcrumbs = array(
            'Разделы баннеров',
        );

        $this->render('banners', array('dataProvider' => $dataProvider));
    }
    
    public function actionIndexBanner($banner_id=null)
    {
        $banner = $this->loadBanner($banner_id);
        $criteria = new CDbCriteria;
        $criteria->addCondition('banner_id = :banner');
        $criteria->params[':banner'] = $banner['id'];
        $dataProvider = new CActiveDataProvider('BannerItem', array(
                'criteria' => $criteria,
                'sort' => array(
                    'defaultOrder' => 'create_time DESC',
                )
            )
        );

        $this->pageTitle = 'Изображения баннеров';
        $this->clips['title'] = 'Изображения баннеров';
        $this->breadcrumbs = array(
            'Разделы баннеров' => array('index'),
            $banner->name,
        );
        $this->render('banner', array('dataProvider'=>$dataProvider,
                                       'banner'=>$banner));
    } 
    
    public function actionCreateBanner()
    {
        $model = new Banner;
        if (isset($_POST['Banner'])) {
            $model->attributes = $_POST['Banner'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Раздел баннеров создан успешно.');
                $this->redirect(array('index'));
            }
        }

        $this->pageTitle = 'Создание раздела баннеров';
        $this->clips['title'] = 'Создание раздела баннеров';
        $this->breadcrumbs = array(
            'Разделы баннеров' => array('index'),
            'Создание'
        );
        $this->render('bannerForm', array('model'=>$model));
    }
    
    public function actionCreateItem($banner_id=null)
    {
        $banner = $this->loadBanner($banner_id);
        $model = new BannerItem(BannerItem::SCENARIO_CREATE);
        if (isset($_POST['BannerItem'])) {
            $model->attributes = $_POST['BannerItem'];
            $model->banner_id = $banner->id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Баннер добавлен успешно.');
                $this->redirect(array('indexBanner', 'banner_id'=>$banner->id));
            }
        }

        $this->pageTitle = 'Добавление изображения';
        $this->clips['title'] = 'Добавление изображения';
        $this->breadcrumbs = array(
            'Разделы баннеров' => array('index'),
            $banner->name => array('indexBanner', 'banner_id'=>$banner->id),
            'Добавление изображения'
        );
        $this->render('itemForm', array('model'=>$model));
    }
    
    public function actionUpdateBanner($banner_id=null) 
    {
        $model = $this->loadBanner($banner_id);


        if (isset($_POST['Banner'])) {
            $model->attributes = $_POST['Banner'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Раздел баннеров сохранен успешно.');
                $this->redirect(array('index'));
            }
        }

        $this->pageTitle = 'Изменение раздела баннеров';
        $this->clips['title'] = 'Изменение раздела баннеров';
        $this->breadcrumbs = array(
            'Разделы баннеров' => array('index'),
            $model->name => array('indexBanner', 'banner_id'=>$model->id),
            'Изменение'
        );
        $this->render('bannerForm', array('model'=>$model));
    }
    
    public function actionUpdateItem($item_id=null)
    {
        $model = $this->loadItem($item_id);
        $banner = $this->loadBanner($model->banner_id);
        if (isset($_POST['BannerItem'])) {
            $model->attributes = $_POST['BannerItem'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Баннер сохранен успешно.');
                $this->redirect(array('indexBanner', 'banner_id'=>$model->banner_id));
            }
        }

        $this->pageTitle = 'Изменение изображения';
        $this->clips['title'] = 'Изменение изображения';
        $this->breadcrumbs = array(
            'Разделы баннеров' => array('index'),
            $banner->name => array('indexBanner', 'banner_id'=>$banner->id),
            'Изменение изображения'
        );
        $this->render('itemForm', array('model'=>$model, 'banner'=>$banner));
    }
    

    public function actionDeleteBanner($banner_id=null)
    {
        $model = Banner::model()->findByPk($banner_id);
        if($model->delete()){
            Yii::app()->user->setFlash('success', 'Раздел баннеров успешно удален.');
            $this->redirect(array('index'));
        }
    }
    
    public function actionDeleteItem($item_id=null) 
    {
        $model = $this->loadItem($item_id);
        if ($model->delete()) {
            Yii::app()->user->setFlash('success', 'Баннер успешно удален.');
      }
      
        $this->redirect(array('indexBanner', 'banner_id'=>$model->banner_id));
    }
    
    protected function loadBanner($id) 
    {
        $model = Banner::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404);
        }
        return $model;
    }
    
    protected function loadItem($id)
    {
        $model = BannerItem::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404);
        }
        return $model;
    }
}
