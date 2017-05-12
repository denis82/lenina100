<?php
Yii::import('pages.models.Page'); 
class DefaultController extends Controller
{
    public $layout = 'main';
    
	public function actionIndex()
	{
	    $page = Page::getCurrentLink();
        $this->pageTitle = $page['page_title'];
        $this->clips['content_title'] = $page['page_title'];
        $this->clips['description'] = $page['description'];
        $this->clips['keywords'] = $page['keywords'];
        
	    $dataProvider = new CActiveDataProvider('Banner', array(
                'sort' => array(
                    'defaultOrder' => 'create_time DESC',
                )
            )
        );
		$this->render('index', array('dataProvider'=>$dataProvider));
	}
    
    public function actionView($url=null) 
    {
        if ($url == null) {
            throw new CHttpException(404);
        }
        $banner = $this->loadBanner($url);
        
        $this->pageTitle = $banner['name'];
        $this->clips['content_title'] = $banner['name'];
        $this->clips['description'] = $banner['name'];
        $this->clips['keywords'] = $banner['name'];

		
        $this->render('view', array('model'=>$banner));
    }
    
    protected function loadBanner($url)
    {
        $model = Banner::model()->find('url = :url', array(':url'=>$url));
        if (!$model) {
            throw new CHttpException(404);
        }
        return $model;
    }
}