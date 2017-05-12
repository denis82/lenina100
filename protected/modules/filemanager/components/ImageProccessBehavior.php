<?php
/**
 * ImageProccessBehavior class file.
 * 
 * @author Alexey Badenkov <badenkov@yandex.ru>
 * @copyright Copyright &copy; 2011 Alexey Badenkov
 * @license http://www.yiiframework.com/license/
 */

/**
 * ImageProcessBehavior will automatically proccess image and put path to new
 * image to other model field. For example you can use this behavior for creating
 * thumbs.
 */
class ImageProccessBehavior extends CActiveRecordBehavior
{
    public $sourceAttribute; // = 'image_url';
    public $destinationAttributes; // = array(
//        'thumb_url' => array(
//            array('adaptiveResize', 126, 87),
//        ),
//    );
    
    public function beforeSave($event)
    {
        $model = $this->getOwner();
        $webroot = Yii::getPathOfAlias('webroot');
        
        $sourceFile = CHtml::resolveValue($model, $this->sourceAttribute);
        if (empty($sourceFile) || !file_exists($webroot.$sourceFile)) {
            return;
        }
        
        $filename = basename($webroot.$sourceFile);
        // Находим дирректорию
        $_p = explode('/', $sourceFile);
        if ( ! empty($_p) ) {
            unset($_p[count($_p)-1]);
        }
        $path = implode('/', $_p).'/';
        unset($_p);
        
        Yii::import('application.vendors.*');
        require_once 'phpthumb/ThumbLib.inc.php';
        
        foreach ( $this->destinationAttributes as $attribute => $operations ) {
            $image = PhpThumbFactory::create($webroot.$sourceFile);
            $destinationFile = $path.$attribute.'_'.$filename;
            
            foreach ($operations as $operation) {
                $args = $operation;
                $method = array_shift($args);
				//replaced by bariew
                //call_user_method_array($method, $image, $args);
                call_user_func_array(array($image, $method), $args);
            }
            
            $image->save($webroot.$destinationFile);
            $model->{$attribute} = $destinationFile;
        }
    }
}