<?php

/**
 * This is the model class for table "{{users_authservice}}".
 *
 * The followings are the available columns in table '{{users_authservice}}':
 * @property string $id
 * @property string $servicename
 * @property integer $user_id
 */
class AuthService extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UsersAuthService the static model class
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
		return '{{authservice}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'servicename' => 'Servicename',
			'user_id' => 'User',
		);
	}

    public function getServiceName()
    {
        $services = array(
            'google' => 'Google',
            'yandex' => 'Yandex',
            'vkontakte' => 'В контакте',
        );

        return isset($services[$this->servicename]) ? $services[$this->servicename] : 'неизвестно';
    }
}
