<?php
Yii::import('expert.models.ExpertItem');

class Faq extends CActiveRecord
{
    /**
     * The followings are the available columns in table 'azh_faq':
     * @var integer $id
     * @var string $name_q
     * @var string $quest
     * @var string $name_a
     * @var string $answer
     * @var integer $status
     * @var integer $category_id
     */

    public $verifyCode;
    public $_status;

    /*
     * Список опций отображающих статус вопроса
     */
    //ожидает ответа
    const STATUS_PENDING = 'faq_pending';
    //черновик
    const STATUS_DRAFT = 'faq_draft';
    //отвечен
    const STATUS_ANSWERED = 'faq_answered';

    /*
     * Список опций указывающих показывать ли вопрос на сайте
     */
    //показывать на сайте
    const STATE_VISIBLE = 'faq_visible';
    //не показывать на сайте
    const STATE_HIDDEN = 'faq_hidden';


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{faq}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name_q', 'length', 'max' => 128),
            array('name_a', 'length', 'max' => 128),
            array('status', 'length', 'max' => 128),
            array('visible', 'length', 'max' => 128),

            //array('verifyCode', 'captcha', 'on'=>'user_question'),
            array('email', 'required', 'on' => 'user_question', 'message' => 'Вы не ввели E-mail'),
            array('name_q', 'required', 'on' => 'user_question', 'message' => 'Вы не ввели имя'),
            array('quest', 'required', 'on' => 'user_question', 'message' => 'Вы не ввели вопрос'),
            array('quest, answer, email', 'safe'),
            array('weight, category_id', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
      return array(
        'category' => array(self::BELONGS_TO, 'FaqCategory', 'category_id'),
				'expert' => array(self::BELONGS_TO, 'ExpertItem', 'name_a'),
      );
    }

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
            'name_q' => 'Ваше имя',
            'quest' => 'Ваш вопрос',
            'name_a' => 'Отвечает',
            'answer' => 'Ответ',
            'status' => 'Статус',
            'category_id' => 'Раздел',
            'weight' => 'Сортировка',
            'verifyCode' => 'Код с картинки',
            'email' => 'e-mail',
            'visible' => 'Видимость на сайте',
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
            && $this->answer) {
                
            $validator=new CEmailValidator;
            if(!$validator->validateValue($this->email))
                return;
            
            Yii::app()->mailManager->send(array(
                'to'=>$this->email,
                'model'=>$this,
                'pattern'=>'faqUserEmailTemplate',
                'subject'=>'Ответ на ваш вопрос',
            ));
        } elseif ($this->isNewRecord) {
            Yii::app()->mailManager->send(array(
                'to'=>Yii::app()->config->get('adminEmail'),
                'model'=>$this,
                'pattern'=>'faqAdminEmailTemplate',
                'subject'=>'Новый вопрос',
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
