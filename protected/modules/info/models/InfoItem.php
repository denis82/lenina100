<?php

/**
 * This is the model class for table "{{info}}".
 *
 * The followings are the available columns in table '{{info}}':
 * @property integer $id
 * @property integer $create_time
 * @property integer $author_id
 * @property integer $update_time
 * @property string $title
 * @property string $annotation
 * @property string $content
 * @property integer $visible_in_rss
 * @property integer $status
 * @property integer $expire_time
 * @property string $logo_url
 */
class InfoItem extends CActiveRecord
{

    public $createTime;
    public $expireTime;

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_ARCHIVE = 2;

    const RSS_INVISIBLE = 0;
    const RSS_VISIBLE = 1;

    /**
     * Returns the static model of the specified AR class.
     * @return info the static model class
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
        return '{{info_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        return array(
            array('createTime, expireTime, title, annotation, content, visible_in_rss, status', 'required'),
            array('category_id, logo_url, update_time, create_time, expire_time, author_id', 'safe'),
            array('content, annotation','filter','filter'=>array($obj=new CHtmlPurifier(),'purify'))
        );
    }

    /**
     * @return array attached behaviors
     */
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => null,
                'updateAttribute' => 'update_time',
                'setUpdateOnCreate' => true,
            ),
            'image'=>array(
                'class'=>'ImageBehavior',
                'fileFields' => array(
                     'full' => array(),
                     'thumb1' => array('adaptiveResize', 125, 125),
                     'thumb2' => array('adaptiveResize', 36, 35),
                )
            )
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array('author' => array(self::BELONGS_TO, 'User', 'author_id'),
                     'category' => array(self::BELONGS_TO, 'InfoCategory', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'title' => 'Заголовок статьи',
            'category_id' => 'Раздел',
            'author_id' => 'Автор',
            'create_time' => 'Дата создания статьи',
            'expire_time' => 'Дата истечения актуальности',
            'expireTime' => 'Дата истечения актуальности',
            'annotation' => 'Краткое описание',
            'content' => 'Текст статьи',
            'visible_in_rss' => 'Показывать в RSS ленте',
            'status' => 'Статус статьи',
            'image' => 'Изображение',
        );
    }

    protected function afterConstruct()
    {
        parent::afterConstruct();
        $this->create_time = $this->expire_time= time();
        $this->afterFind();
    }

    protected function afterFind()
    {
        $this->createTime = Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->create_time);
        $this->expireTime = Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->expire_time);
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        $this->create_time = CDateTimeParser::parse($this->createTime,'dd.MM.yyyy');
        $this->expire_time = CDateTimeParser::parse($this->expireTime,'dd.MM.yyyy');

        return true;
    }

    public function getCategoryOptions()
    {
        $categories = Yii::app()->controller->categories;
        $result = array(
            0 => 'Без раздела',
        );
        foreach ($categories as $category) {
            $result[$category->id] = $category->title;
        }

        return $result;
    }

    public function getCategoryText()
    {
        $category = InfoCategory::model()->findByPk($this->category_id);
        if ($category === null) {
            return 'Неизвестный раздел';
        }

        return $category->title;
    }

    public function getStatusOptions()
    {
        return array(self::STATUS_DRAFT => 'Черновик',
                     self::STATUS_PUBLISHED => 'Опубликовано',
                     self::STATUS_ARCHIVE => 'Архив',
                     );
    }

    public function getStatusText()
    {
        if (array_key_exists($this->status, $this->statusOptions)) {
            $status = $this->statusOptions[$this->status];
        } else {
            $status = 'Неправильный статус';
        }

        return $status;
    }

    public static function getTimeStatusList()
    {
        return array(
            'all' => 'Все',
            'past' => 'Прошедшие',
            'present' => 'Текущие',
            'future' => 'Будущие',
        );
    }

}

