<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Image
 *
 * @author V
 */
class ImageModel extends CFormModel {

    public $image;
    public $width;
    public $height;
    public $alt;
    public $class;
    public $path;
    public $isLink;
    public $oldPath;
    public $title;

    public function rules() {
        return array (
            array('path', 'required'),
            array('image, path, isLink, title', 'safe'),
            array('width, height', 'numerical', 'integerOnly'=>true, 'allowEmpty'=>true),
            array('class, alt', 'length', 'allowEmpty'=>true)
        );
    }

    public function  attributeLabels() {
        return array(
            'image'=>'Картника',
            'width'=>'Ширина',
            'height'=>'Высота',
            'alt'=>'Альтернативный текст',
            'class'=>'Класс CSS',
            'path'=>'Путь',
            'isLink'=>'Ссылка',
            'title'=>'title ссылки'
        );
    }

    public function afterValidate() {
        parent::afterValidate();
        if(!$this->hasErrors()) {
            $dir = strrpos($this->path, "|");
            $dirName = str_replace("|", DIRECTORY_SEPARATOR, substr($this->path, 0, $dir)).DIRECTORY_SEPARATOR."resized";
            $filePath = substr($this->path, $dir+1);
            
            $dir = Yii::app()->file->set($dirName);

            if(!$dir->isDir) {
                $dir->createDir(0777);
                $dir = Yii::app()->file->set(Yii::getPathOfAlias('webroot.'.$dirName));
            }

            $this->oldPath = $dir->dirname.DIRECTORY_SEPARATOR.$filePath;

            $this->image = Yii::app()->image->load($this->oldPath);
            
            if($this->image->width != $this->width || $this->image->height != $this->height) {
                $this->image = $this->resizeImageProportionaly($this->width, $this->height, $this->image);
                $this->path = $dir->realPath.DIRECTORY_SEPARATOR.$filePath;
                $this->image->save($this->path);
            } else {
                $this->path = $dir->dirname.DIRECTORY_SEPARATOR.$filePath;
            }
        }
    }

    protected function resizeImageProportionaly($width, $height, $image) {
        $scaleRatio = $width / $image->width;
        $from = $height / $width;
        $to = $image->height / $image->width;
        if($from >= $to) {
            $w = $image->height * $width / $height;
            $h = $image->height;
        } else if($from < $to) {
            $h = $image->width * $height / $width;
            $w = $image->width;
        }
        $image->crop($w, $h);
        $image->resize($width, $height);

        return $image;
     }

     public function getUrl() {
         $p = str_replace(Yii::app()->file->set(Yii::getPathOfAlias("webroot"))->realPath, "", $this->path);
         return str_replace(DIRECTORY_SEPARATOR, "/", $p);
     }

     public function getHtml() {
         if($this->isLink) {
             return $this->getLink();
         } else {
             return $this->getImage();
         }
     }

     private function getLink() {
         $p = str_replace(Yii::app()->file->set(Yii::getPathOfAlias("webroot"))->realPath, "", $this->oldPath);
         $linkUrl = str_replace(DIRECTORY_SEPARATOR, "/", $p);

         return CHtml::link($this->getImage(), $linkUrl, array('class'=>'thickbox',
             'title'=>$this->title));
     }

     private function getImage() {
         $p = str_replace(Yii::app()->file->set(Yii::getPathOfAlias("webroot"))->realPath, "", $this->path);
         $url = str_replace(DIRECTORY_SEPARATOR, "/", $p);
         $attributes = array();

         if(!empty($this->class)) {
             $attributes['class'] = $this->class;
         }
         $attributes['width'] = $this->width;
         $attributes['height'] = $this->height;

         return CHtml::image($url, $this->alt, $attributes);
     }

}
