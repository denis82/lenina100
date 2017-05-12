<?php

class DefaultController extends Controller
{
    public $pageTitle = "Новости";
    public $categories = array();
    const PAGE_SIZE = 10;

    protected $withCategories = false;

    public function beforeAction($action)
    {
         if (!parent::beforeAction($action)) {
             return false;
         }

         $this->categories = NewsCategory::model()->findAll();
         $this->withCategories = !empty($this->categories);
         return true;
    }


    public function actionIndex($category_url=null)
    {
        $category = $this->loadCategory($category_url);

        $criteria = new CDbCriteria();
        $criteria->addCondition('status = :status');
        $criteria->addCondition('create_time <= :time');
        $criteria->order = 'create_time DESC';
        $criteria->params = array(':status' => NewsItem::STATUS_PUBLISHED,
                                  ':time' => time());

        if (!empty($category)) {
            $criteria->addCondition('category_id = :category_id');
            $criteria->params[':category_id'] = $category->id;
        }

        $dataProvider = new CActiveDataProvider('NewsItem', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => self::PAGE_SIZE),
        ));
		$this->clips['is_main_news'] = true;
		$this->clips['content_title'] = 'Новости';

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionView($id=null)
    {
        $model = $this->loadNewsItem($id);

        $this->pageTitle = $model['title'];
        $this->breadcrumbs = array(
            'Новости' => array('index'),
            $model['title']
        );
        $this->render('view', array(
            'item' => $model,
        ));
    }

    public function actionRss()
    {
        $news = $this->rssNews;
        if(!$news) 
            return;
        $feed = new EFeed();

        $feed->title= 'Новости';
        $feed->description = 'Новости';
        $feed->link = $this->createAbsoluteUrl('/');

        $feed->setImage('Название картинки','http://www.3colors.ru',
        'http://3colors.ru/themes/colors/images/logo.png');

        $feed->addChannelTag('language', 'ru-ru');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));

        foreach ($news as $model) {
            $item = $feed->createNewItem();

            $item->title = $model->title;
            $item->link = $this->withCategories
                             ? $this->createAbsoluteUrl('/news/default/view',
                                                        array('id' => $model->id,
                                                              'category_url' => $model->category['url']))
                             : $this->createAbsoluteUrl('/news/default/view',
                                                        array('id' => $model->id));
            $item->date = $model->create_time;
            $item->description = $model->annotation;

            $item->addTag('author', $model->author['email']
                                    . ' ('
                                    . $model->author['name']
                                    . ')');
            $item->addTag('guid',
                          $this->createAbsoluteUrl('/news/default/view',
                                                   array('id' => $model->id)),
                          array('isPermaLink' => 'true'));

            $feed->addItem($item);
        }

        $feed->generateFeed();
    }

    public function getRssNews()
    {
        return NewsItem::model()->findAllByAttributes(
            array('status'=>NewsItem::STATUS_PUBLISHED, 'visible_in_rss'=>NewsItem::RSS_VISIBLE),
            array('condition'=>'create_time <= '. time(), 'order'=>'create_time DESC')
        );
    }

    protected function loadNewsItem($id)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('id = :id');
        $criteria->addCondition('create_time <= :time');
        $criteria->addCondition('expire_time >= :time OR expire_time IS NULL OR expire_time=0');
        $criteria->addCondition('status = :status');
        $criteria->params = array(':id' => $id,
                                  ':time' => time(),
                                  ':status' => NewsItem::STATUS_PUBLISHED);
        $model = NewsItem::model()->find($criteria);

        if ($model === null) {
            throw new CHttpException(404, 'Нет такой новости');
        }

        return $model;
    }

    protected function loadCategory($category_url)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'url = :url';
        $criteria->params = array(':url' => $category_url);
        $category = NewsCategory::model()->find($criteria);

        if ($category === null && isset ($category_url)) {
            throw new CHttpException(404, 'Категория не сущевствует');
        }

        return $category;
    }
}
