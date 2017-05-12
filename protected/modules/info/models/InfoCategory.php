<?php

/**
 * This is the model class for table "{{info}}".
 *
 * The followings are the available columns in table '{{info}}':
 * @property integer $id
 */
class InfoCategory extends CActiveRecord
{
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
        return '{{info_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title', 'required'),
			array('url', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'items' => array(
                self::HAS_MANY, 'InfoItem', 'category_id',
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
