<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property integer $id
 */
class NewsCategory extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return news the static model class
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
        return '{{news_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title', 'required'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'items' => array(
                self::HAS_MANY, 'NewsItem', 'category_id',
                'order' => 'create_time DESC',
                //'limit' => 4,
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
            'title' => 'Название раздела',
        );
    }

    protected function afterDelete()
    {
        if ( ! parent::beforeDelete() )
            return false;

        foreach ( $this->items as $item )
        {
            $item->delete();
        }

        return true;
    }
}
