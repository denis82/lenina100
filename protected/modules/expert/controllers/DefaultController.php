<?php
Yii::import('pages.models.Page'); 
class DefaultController extends Controller
{
    public $layout = 'main';
    
	public function actionIndex($url=false)
	{
	  $this->pageTitle = $this->clips['title'] = $this->clips['keywords']
             = $this->clips['description'] = 'Специалисты';
		$this->clips['content_title'] = 'Специалисты';
             
		$data = array();
    if($url){
			 $category = is_numeric($url) 
					? Expert::model()->findByPk($url)
					: Expert::model()->findByAttributes(array('url'=>$url));
			 if(!$category)
					throw new CHttpException(404);
					
			 $this->pageTitle .=' ' .$category->name;
			 $this->clips['title'] .=' ' .$category->name;
			 $this->clips['keywords'] .=' ' .$category->name;
			 $this->clips['description'] .=' ' .$category->name;
			 
			$condition = 'expert_id='.$category->id;
			$items = ExpertItem::model()->findAll(
				array(
					'condition' => $condition,
					'params'=>array(),
					'order'=>'expert_id ASC, create_time DESC',
				)
			);
			if ($category->name != 'Администрация')
				$data[] = array('category_name' => $category->name, 'items' => $items);
			else 
				$data[] = array('category_name' => '', 'items' => '');
    }
		else {
			$categories = Expert::model()->findAll(
			array(	
				'condition'=> '',
				'select'=> '*',
				'params'=> array(),
				'order'=> 'id ASC'
			));
			foreach ($categories as $category) {
				if ($category->name == 'Администрация') continue;
				$condition = 'expert_id='.$category->id;
				$items = ExpertItem::model()->findAll(
					array(
						'condition' => $condition,
						'params'=>array(),
						'order'=>'name ASC',
					)
				);
				if (count($items) > 0) $data[] = array('category_name' => $category->name, 'items' => $items);
			}
		}

		$dataProvider = new CArrayDataProvider($data, array(
				'sort' => array(
					'defaultOrder' => '',
				))
		);

		$this->render('index', array(
				'dataProvider' => $dataProvider,
		));
	}
    
    public function actionView($url=null) 
    {
        if ($url == null) {
            throw new CHttpException(404);
        }
        $expert = $this->loadExpert($url);
        
        $this->pageTitle = $expert['name'];
        $this->clips['content_title'] = $expert['name'];
        $this->clips['description'] = $expert['name'];
        $this->clips['keywords'] = $expert['name'];

		
        $this->render('view', array('model'=>$expert));
    }
	
	public function actionExpertBox($id=null) 
    {
        if ($id == null) {
            throw new CHttpException(404);
        }
        $model = ExpertItem::model()->findByPk($id);
        
        $this->pageTitle = $model['name'];
        $this->clips['content_title'] = $model['name'];
        $this->clips['description'] = $model['name'];
        $this->clips['keywords'] = $model['name'];

        $this->renderPartial('expert_table', array('data'=>$model));
    }
    
    protected function loadExpert($url)
    {
        $model = Expert::model()->find('url = :url', array(':url'=>$url));
        if (!$model) {
            throw new CHttpException(404);
        }
        return $model;
    }
}