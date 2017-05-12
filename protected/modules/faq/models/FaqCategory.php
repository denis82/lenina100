<?php

class FaqCategory extends CActiveRecord 
{
    /**
     * The followings are the available columns in table 'azh_faq_category':
     * @var integer $id
     * @var string $title
     * @var integer $weight
     * @property string $url
     */

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
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
        return '{{faq_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() 
    {
        return array(
            array('title', 'length', 'max' => 128),
            array('title', 'required'),
			array('url', 'safe'),
            array('weight', 'numerical', 'integerOnly' => true),
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
            'title' => 'Название',
            'url' => 'Url раздела',
            'weight' => 'Вес',
        );
    }
    
    public static function getCategoryOptions() 
    {
        return self::model()->findAll();
    }
}