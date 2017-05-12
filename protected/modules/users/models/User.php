<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $role
 * @property string $name
 * @property integer $create_time
 * @property integer $update_time

 */

class User extends CActiveRecord
{
    public $new_password;
    public $new_password_repeat;
    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
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
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('email', 'email'),
            array('email', 'unique'),
            array('role', 'length', 'max' => 255),
            array('name', 'length', 'max' => 255),

            array('new_password, new_password_repeat', 'length', 'max' => 255),
            array('new_password', 'compare'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'authServices' => array(self::HAS_MANY, 'AuthService', 'user_id'),
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
            'email' => 'E-mail',
            'password' => 'Пароль',

            'new_password' => 'Новый пароль',
            'new_password_repeat' => 'Повтор пароля',

            'salt' => 'Соль',
            'role' => 'Роль',
            'name' => 'ФИО',


            
            'create_time' => 'Дата регистрации',
            'update_time' => 'Дата обновления',
        );
    }

    protected function hashPassword($password)
    {
        return sha1($password);
    }

    public function validatePassword($password)
    {
        return $this->password == $this->hashPassword($password);
    }

    public function getRoleOptions()
    {
        $am = Yii::app()->authManager;
        $ai = $am->roles;

        $roles = array();
        foreach ($ai as $item) {
            $roles[$item->name] = $item->description;
        }
        return $roles;
    } 

    protected function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }

        if (!empty($this->new_password)) {
            $this->password = $this->hashPassword($this->new_password);
        }

        return true;
    }
    
    public function setPassword($pass)
    {
        $this->password = $this->hashPassword($pass);
    }
}

