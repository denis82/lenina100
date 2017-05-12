<?php

/**
 * This is the model class for table "{{expertes}}".
 *
 * The followings are the available columns in table '{{expertes}}':
 * @property integer $id
 * @property integer $create_time
 * @property integer $update_time
 * @property string $name
 * @property string $url
 * @property string $description
 */
class Expert extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Expert the static model class
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
		return '{{expertes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, url, description', 'required'),
			array('create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>255),
			array('create_time, update_time', 'safe'),
		);
	}
    
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
                'setUpdateOnCreate' => true,
            )
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'itemsCount' => array(self::STAT, 'ExpertItem', 'expert_id'),
            'items' => array(self::HAS_MANY, 'ExpertItem', 'expert_id'),
		);
	}

  public function afterDelete()
  {
    parent::afterDelete();
    foreach($this->items as $item) {
      $item->delete();
    }
  }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'name' => 'Название отдела',
			'url' => 'Url отдела',
			'description' => 'Описание отдела',
		);
	}
}
