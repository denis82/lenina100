<?php

/**
 * This is the model class for table "{{pages}}".
 *
 * The followings are the available columns in table '{{pages}}':
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $create_time
 * @property string $url
 * @property string $name
 * @property string $image_menu
 * @property string $layout
 * @property string $content
 * @property string $right_content
 * @property string $price_content
 * @property string $symbol_separator
 * @property boolean $is_visible
 * @property string $content_title, заголовок страницы,
 * предполагается что это <h1> для блока с контентом
 * @property string $page_title заголовок страницы,
 * подставляется в тэг <title>
 */
class Page extends ActiveRecord
{
    /**
     * @var array for build ierarchical tree (NestedSetBehavior)
     */
    public $childs;
    private $oldUrl;
    const SCENARIO_PAGE = 'scenario_page';
    const SCENARIO_LINK = 'scenario_link';

    /**
     * @var array page where we are now
     */
    public static $currentPage;

    /**
     * Returns the static model of the specified AR class.
     * @return pages the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{pages}}';
    }

    public function behaviors()
    {
        return array(
            'tree' => array(
                'class' => 'NestedSetBehavior',
                'hasManyRoots' => false,
                'rootAttribute' => 'root',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'levelAttribute' => 'level',
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('url, content_title, page_title, label, name', 'required', 'on' => self::SCENARIO_PAGE),
            array('keywords, description', 'length'),
            array('lft, rgt, level, create_time, is_visible, type', 'numerical', 'integerOnly' => true),
            array('url, layout', 'length', 'max' => 255),
            array('layout', 'length', 'allowEmpty' => true),
            array('name, label, param, type, page_title', 'required', 'on' => self::SCENARIO_LINK),
            array('language_code, image_menu, symbol_separator', 'safe'),
			array('right_content, content, price_content', 'type', 'type'=>'string'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'level' => 'Level',
            'create_time' => 'Create Time',
            'url' => 'Абсолютный URL',
            'content' => 'Содержание страницы',
			'right_content' => 'Правый контент',
			'price_content' => 'Прейскурант',
			'symbol_separator' => 'Разделитель',
            'type' => 'Тип страницы',
            'is_visible' => 'Показывать страницу',
            'content_title' => 'Заголовок страницы (h1)',
            'label' => 'Название пункта меню',
            'name' => 'URL страницы',
            'layout' => 'Макет',
            'param' => 'URL страницы',
            'keywords' => 'Keywords (ключевые слова)',
            'description' => 'Description (описание)',
            'page_title' => 'Заголовок страницы (title)',
            'type' => 'Ссылка',
			'image_menu' => 'картинка страницы для меню',
        );
    }

    /**
     * Return the record from {{pages}} table representing current page
     * @return array Single record from db representing current page
     */
    public static function getCurrentPage($active=true)
    {
       $url = $_SERVER['REQUEST_URI'];

       $page = self::model()->findByAttributes(array('url'=>$url), array('order'=>'id ASC'));
       if(!$page && $active)
            return false;
        
        self::$currentPage = $page;
        return self::$currentPage;
    }

    public static function getCurrentLink($url=null)
    {
        if (!isset(self::$currentPage) || empty(Page::$currentPage)) {
			if ($url == null) {
			    if (isset($_GET['route']) && !empty($_GET['route'])) {
			        $route = $_GET['route'];
			    } else {
			        $route = Yii::app()->request->pathInfo;
			    }
			} else {
			    $route = $url;
			}

			if (Yii::app()->language != Yii::app()->sourceLanguage) {
				$route = str_replace(Yii::app()->language . '/', '', $route);
			}

		   	$route = '/' . (isset($route) ? $route : '');
		  	$criteria = new CDbCriteria;
		   	$criteria->condition = 'param = :url';
	 	  	$criteria->params = array(':url' => $route);

	 	  	$page = Page::model()->find($criteria);

		    if ($page) {
		        self::$currentPage = $page;
		        return self::$currentPage;
		    } else {
		        //do nothing
			}
        } else {
            return self::$currentPage;
        }
    }

    protected function beforeValidate() {
        if (!parent::beforeValidate())
            return false;

        $this->oldUrl = trim($this->url);
        $this->create_time = time();

        if ($this->scenario == self::SCENARIO_PAGE) {
            $this->param = '';
            $this->type = 0;
            if (isset($this->url))
                $this->url = trim($this->url);
            if (isset($this->name)) {
                $this->name = strtr(trim($this->name), array('/'=>''));
                if ($this->level == 1) $this->name = '/';
            }

        }

        if ($this->scenario == self::SCENARIO_LINK) {
            $this->type = 1;
            $this->url = '';
            $this->param = preg_replace('/^(\/)?(.*)/', '/$2', $this->name);
        }
        if ($this->type == 0){
            if (!$this->isNewRecord && $parent = $this->getParent()) {
                $this->url = $parent->url . ($parent->name == '/' ? '' : '/') . $this->name;
            }
            $this->url = preg_replace(array('/^(\/)?(.*)/', '/\/\//'), array('/$2', '/'), $this->url);
        }

        return true;
    }

    protected function afterSave() {
        parent::afterSave();
        if (!empty($this->url) && $this->url != '/') {
            $descendants = $this->descendants()->findAll();
            foreach ($descendants as $descendant) {
                if (!empty($descendant->param) OR empty($descendant->url))
                    continue;

                if (strpos($descendant->url, $this->url) === 0 || empty($this->oldUrl)) {
                    continue;
                }

                $descendant->url = substr_replace($descendant->url, $this->url, 0, strlen($this->oldUrl));
                $descendant->saveNode(false);
            }
        }
    }
}