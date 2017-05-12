<?php
/*
 * class EArray for search in array of ActiveRecord objects
 *
 * @author Roman Yuferov <exromany@gmail.com>
 */
 class EArray {

     /*
      * Вылирает записи по атрибуту
      * @param array $array - массив объектов ActiveRecord
      * @param string $attribute - атрибут, по которому производить поиск
      * @param mixed $value - значение атрибута
      * @param boolean $many - Вернуть массив из всех совпадений. По умолчанию false - вернуть первый объект
      */
     public static function find($array, $attribute, $value, $many = false)
     {
        $result = array();
        foreach($array as $item) {
            if ($item->getAttribute($attribute) === $value) {
                if ($many) $result[] = $item;
                else return $item;
            }
        }
        return $many ? $result : null;
     }

 }
