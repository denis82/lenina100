<?php

class DefaultController extends Controller
{
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0xde3d36,
                'minLength' => 4,
                'maxLength' => 6,
                'testLimit'=>'1',
            ),
        );
    }

    public function actionIndex($category_url=false)
    {
        $this->pageTitle = $this->clips['title'] = $this->clips['keywords']
             = $this->clips['description'] = 'Новые вопросы и ответы';
             
        if($category_url){
             $category = is_numeric($category_url) 
                ? FaqCategory::model()->findByPk($category_url)
                : FaqCategory::model()->findByAttributes(array('url'=>$category_url));
             if(!$category)
                throw new CHttpException(404);
                
             $this->pageTitle .=' ' .$category->title;
             $this->clips['title'] .=' ' .$category->title;
             $this->clips['keywords'] .=' ' .$category->title;
             $this->clips['description'] .=' ' .$category->title;
        }
		$this->clips['content_title'] = $category->title . ': вопросы и ответы';
		if (!$category->url) $this->clips['content_title'] = 'Все вопросы и ответы';
        
        $condition = isset($category) ? 'category_id = '.$category->id : 'category_id > 0';
		$items = Faq::model()->findAll(
            array(
				'condition' => 'status=:status AND visible=:visible AND '.$condition,
				'params'=>array(':status'=>Faq::STATUS_ANSWERED, ':visible'=>Faq::STATE_VISIBLE),
				'order'=>'weight ASC, create_time DESC',
            )
        );
        
		// $items = Faq::model()->findAllByAttributes(
            // array(
                // 'status' => Faq::STATUS_ANSWERED,
                // 'visible' => Faq::STATE_VISIBLE,
                // 'category_id' => isset($category) ? $category->id : 0
            // ), 
            // array('order'=>'weight ASC, create_time DESC')
        // );

        $dataProvider = new CArrayDataProvider($items, array(
            'pagination' => array(
                'pageSize' => 0
            )
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAsk()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = false;
        }

        $model = new Faq('user_question');

        if (isset($_POST['Faq'])) {
            $model->attributes = $_POST['Faq'];
            $model->status = Faq::STATUS_PENDING;
            $model->visible = Faq::STATE_HIDDEN;
            $model->category_id = 0;

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Вопрос успешно задан.');
                if (!Yii::app()->request->isAjaxRequest) {
                    $this->refresh();
                }
            }
        }

        $this->breadcrumbs = array(
            'Вопрос-ответ' => array('index'),
            'Задать вопрос',
        );

        $this->render('ask', array(
            'model' => $model,
        ));
    }
}

