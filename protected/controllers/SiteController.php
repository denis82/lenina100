<?php

class SiteController extends Controller
{
    public $page;
    
    public function beforeAction($action)
    {
        $view = $action->id;
        $this->page = Yii::app()->db
            ->createCommand("SELECT * FROM {{pages}} WHERE `url` = '/$view' OR `param` = '/$view'")
            ->queryRow();

        $this->pageTitle = $this->page['page_title'];
        $this->clips['content_title'] = $this->page['content_title'];
        $this->clips['description'] = $this->page['description'];
        $this->clips['keywords'] = $this->page['keywords'];
        return true;
    }
	
	public function actionMap()
	{
		if (Yii::app()->request->isAjaxRequest)
			$this->renderPartial('map');
		else
			$this->render('map');
	}

    public function actionIndex()
    {
        $this->render('index');
    }
     /**
     * Обратная связь
     */
    public function actionContacts($map=true)
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])){
            $model->attributes = $_POST['ContactForm'];
            if ($model->send()){
                Yii::app()->user->setFlash('contact', 'Сообщение успешно отправлено.');
                $this->refresh();
            }
        }
        if(Yii::app()->request->isAjaxRequest){
            if($map)
                $this->renderPartial('contacts', array('model' => $model, 'content' => $this->page['content']));
            else
                $this->renderPartial('_feedback', array('model' => $model));
        }else{
            $this->render('contacts', array('model' => $model, 'content' => $this->page['content']));
        }
    }

    public function actionOrder()
    {
        $model = new OrderForm;
        if (isset($_POST['OrderForm'])){
            $model->attributes = $_POST['OrderForm'];
            if ($model->send()){
                Yii::app()->user->setFlash('contact', 'Заказ успешно отправлен.');
                $this->refresh();
            }
        }
        $render = Yii::app()->request->isAjaxRequest ? 'renderPartial' : 'render';
        $this->$render('order', array('model' => $model, 'content' => $this->page['content']));
    }
	
	public function actionMessage($view = 'message')
    {
		$model = new MessageForm;
		if (isset($_POST['MessageForm'])){
            $model->attributes = $_POST['MessageForm'];
            if ($model->send()){
                Yii::app()->user->setFlash('message', 'Сообщение успешно отправлено.');
                if (!Yii::app()->request->isAjaxRequest) {
                    // успешно и не аякс
                    $this->refresh();
                } else {
                    // успешно и аякс
                    echo '{"status":"Ваше сообщение успешно отправлено."}';
                    return;
                }
            }
        }

		if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial('message', array('model' => $model));
        } else {
            $this->render('message', array('model' => $model));
        }
    }
	
	public function actionAppointment()
    {
		$model = new AppointmentForm;

		Yii::log('отправляю');
		if (isset($_POST['AppointmentForm'])){
            $model->attributes = $_POST['AppointmentForm'];
            if ($model->send()){
                Yii::app()->user->setFlash('appointment', 'Сообщение успешно отправлено.');
                if (!Yii::app()->request->isAjaxRequest) {
                    // успешно и не аякс
                    $this->refresh();
                } else {
                    // успешно и аякс
                    echo '{"status":"<center>Ваше сообщение успешно отправлено.</center>"}';
                    return;
                }
            }
        }

		if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial('appointment', array('model' => $model));
        } else {
            $this->render('appointment', array('model' => $model));
        }
    }

	
    /**
     * This is the action to handle external exceptions.
     */
    
    public function actionError($error=array('code'=>404, 'message'=>'Данной страницы не существует.'))
    {
        if(Yii::app()->errorHandler->error)
            $error = Yii::app()->errorHandler->error;
        
        $this->pageTitle = 'Ошибка '.$error['code'];
        $this->breadcrumbs = array('Ошибка ' . $error['code']);
        $this->render('error', $error);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionManualError($id = 404, $text = false)
    {
        throw new CHttpException($id, $text);
    }

    /* SITE MAP EXTENSION FUNCTIONS */
    public function actionSiteMap()
    {
        $sql = "SELECT node.id, node.label, node.url, node.param, node.level
                FROM {{pages}} AS node, {{pages}} AS parent
                WHERE
                    (node.lft BETWEEN parent.lft AND parent.rgt)
                    AND parent.id = 1
                ORDER BY node.lft";
        
        $this->pageTitle = 'Карта сайта на ' . Yii::app()->name;
        $this->clips['content_title'] = $this->clips['keywords'] 
            = $this->clips['description'] = 'Карта сайта';
        
        
        $items = Yii::app()->db->createCommand($sql)->queryAll();

        $this->render('sitemap', array(
            'items' => $items,
        ));
    }
    
    public function actionSiteMapXml()
    {
        $this->renderPartial('sitemapxml', array('list' => $this->getSiteMap()));
    }
    
    public function getSiteMap()
    {
        $webRoot = Yii::app()->getBaseUrl(true);
        $modules = Yii::app()->modules;
        $unset = array('users', 'filemanager', 'configs', 'shop');
        $models = array(
            array(
                'model' => 'Page',
                'path' => $webRoot,
                'priority' => 0.9,
                'condition' => "WHERE type = 0 AND is_visible = 1",
                'id' => 'url', 
            ),
            array(
                'model' => 'CatalogCategory',
                'path' => $webRoot.'/catalog/',
                'priority' => 0.9,
                'condition' => "",
                'id' => 'id', 
            ),
            array(
                'model' => 'CatalogItem',
                'path' => $webRoot.'/catalog/view/',
                'priority' => 0.8,
                'condition' => "WHERE visible = 1",
                'id' => 'id', 
            ),
        );
        $result = array(
            'static' => array(
                array('title' => 'Главная', 'url' => $webRoot.'/', 'priority' => 1),
            )
        );

        foreach(array_keys($modules) as $module){
            if(in_array($module, $unset))
                continue;
            Yii::import($module. '.models.*');
        }

        foreach($models as $modelParams){
            $model = CActiveRecord::model($modelParams['model']); 
            if(!$model || !method_exists($model, 'sitemap'))
                continue;
            $result[] = $model->sitemap($modelParams); 
        }
        return $result;
    }
}
