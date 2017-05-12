<?php
/**
 * Description of AuthModel
 *
 * @author V
 */
class AuthModel extends CModel 
{

    /**
     * Роли пользователей
     */
    //super user
    const ROLE_ROOT = 'root';
    //site administrator
    const ROLE_ADMIN = 'admin';
    //authorized user
    const ROLE_USER = 'user';
    
    public function attributeNames() 
    {
        return array();
    }
    
    /**
     * Returns an array of available roles
     * @return array 
     */
    public static function getRoleOptions() 
    {
        if (Yii::app()->user->role == self::ROLE_ROOT) {
            return array(self::ROLE_ROOT =>'Суперпользователь ',
                         self::ROLE_ADMIN => 'Администратор',
                         self::ROLE_USER => 'Зарегистрированный пользователь');
        } else {
            return array(self::ROLE_ADMIN => 'Администратор',
                         self::ROLE_USER => 'Зарегистрированный пользователь');
        }
    }
    
    public static function getAuthRules()
    {
        return array(
            'guest' => array(
                'type' => CAuthItem::TYPE_ROLE,
                'description' => 'Гость',
                'bizRule' => null,
                'data' => null,
            ),
            self::ROLE_USER => array(
                'type' => CAuthItem::TYPE_ROLE,
                'description' => 'Зарегистрированный пользователь',
                'bizRule' => null,
                'data' => null,
            ),
            self::ROLE_ADMIN => array(
                'type' => CAuthItem::TYPE_ROLE,
                'description' => 'Администратор',
                'bizRule' => null,
                'data' => null,
            ),
            self::ROLE_ROOT => array(
                'type' => CAuthItem::TYPE_ROLE,
                'description' => 'Суперпользователь',
                'bizRule' => null,
                'data' => null,
            ),
        );
    }
}
