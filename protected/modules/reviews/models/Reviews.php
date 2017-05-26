<?php
Yii::import('expert.models.ExpertItem');

class Reviews extends CActiveRecord
{
    /**
     * The followings are the available columns in table 'azh_faq':
     * @var integer $id
     * @var string $name_reviews
     * @var string $quest
     * @var string $name_a
     * @var string $answer
     * @var integer $status
     * @var integer $category_id
     */
    public $agree;
    public $verifyCode;
    public $_status;

    /*
     * Список опций отображающих статус вопроса
     */
    //ожидает ответа
    const STATUS_PENDING = 'reviews_pending';
    //черновик
    const STATUS_DRAFT = 'reviews_draft';
    //отвечен
    const STATUS_ANSWERED = 'reviews_answered';

    /*
     * Список опций указывающих показывать ли вопрос на сайте
     */
    //показывать на сайте
    const STATE_VISIBLE = 'reviews_visible';
    //не показывать на сайте
    const STATE_HIDDEN = 'reviews_hidden';


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{reviews}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name_review', 'length', 'max' => 128),
            //array('name_a', 'length', 'max' => 128),
            array('status', 'length', 'max' => 128),
            array('visible', 'length', 'max' => 128),

            //array('verifyCode', 'captcha', 'on'=>'user_question'),
            //array('email', 'required', 'on' => 'user_question', 'message' => 'Вы не ввели E-mail'),
            //array('name_q', 'required', 'on' => 'user_question', 'message' => 'Вы не ввели имя'),
            array('reviews, name_review', 'required', 'on' => 'user_question', 'message' => 'Вы не ввели отзыв'),
            array('reviews', 'safe'),
            array('weight', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * @return array relational rules.
     */
//     public function relations()
//     {
//       return array(
//         'category' => array(self::BELONGS_TO, 'FaqCategory', 'category_id'),
// 				'expert' => array(self::BELONGS_TO, 'ExpertItem', 'name_a'),
//       );
//     }

    public function scopes()
    {
        return array(
            'statused' => array(
                'condition' => 'status=1',
            ),
            'waiting' => array(
                'condition' => 'status="' . self::STATUS_PENDING . '"' ,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name_review' => 'Ваше имя',
            'reviews' => 'Ваш отзыв',
            'status' => 'Статус',
            'weight' => 'Сортировка',
            'visible' => 'Видимость на сайте',
            'agree' => 'Я согласен на обработку персональных данных*',
        );
    }

    protected function beforeValidate()
    {
        if (!parent::beforeValidate())
            return false;

        if ($this->isNewRecord) {
            $this->create_time = $this->update_time = time();
        } else {
            $this->update_time = time();
        }

        return true;
    }

    protected function afterFind() {
        $this->_status = $this->status;
        return parent::afterFind();
    }

    protected function afterSave()
    {
        parent::afterSave();

        if ($this->status == 'faq_answered'
            && $this->status != $this->_status
            && $this->email != null
            && $this->reviews) {
                
            $validator=new CEmailValidator;
            if(!$validator->validateValue($this->email))
                return;
            
            Yii::app()->mailManager->send(array(
                'to'=>$this->email,
                'model'=>$this,
                'pattern'=>'faqUserEmailTemplate',
                'subject'=>'Ответ на ваш отзыв',
            ));
        } elseif ($this->isNewRecord) {
            Yii::app()->mailManager->send(array(
                'to'=>Yii::app()->config->get('adminEmail'),
                'model'=>$this,
                'pattern'=>'faqAdminEmailTemplate',
                'subject'=>'Новый отзыв',
            ));
        }
    }

    public function send($validate = true)
    {
        if ($validate AND ! $this->validate()){
            return false;
        }

       return Yii::app()->mailManager->send(array(
            'to' => Yii::app()->config->get('adminEmail'),
            'subject'=>'Новый запрос на звонок на сайте '.Yii::app()->name,
            'model'=>$this,
            'pattern'=>'messageEmailTemplate',
        ));
    }
    
    public function getStatusOptions()
    {
        return array(
            self::STATUS_PENDING => 'Ждет ответа',
            self::STATUS_DRAFT => 'Черновик',
            self::STATUS_ANSWERED => 'Отвечен',
        );
    }

    public function getVisibilityOptions()
    {
        return array(
            self::STATE_HIDDEN => 'Не показывать на сайте',
            self::STATE_VISIBLE => 'Показывать на сайте',
        );
    }
}
