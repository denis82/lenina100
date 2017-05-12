<?php
 Yii::import('application.vendors.*');
class ImageBehavior extends CActiveRecordBehavior
{
    protected $full, $thumb1, $thumb2, $thumb3, $thumb4, $thumb5;
    public $name = 'image';
    public $extension = 'jpg';
    public $allowed = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff');
    public $noimage = 'noimage.jpg';
    public $nameField = false;
    public $uploadedFile = false;
    private $mode = true;
    
    public $fileFields = array(
         'full' => array(),
         'thumb1' => array('adaptiveResize', 50, 50),
         'thumb2' => array('adaptiveResize', 150, 100),
         'thumb3' => array('adaptiveResize', 250, 150)
    );

    public function afterSave()
    {
        if(!$this->mode)
            return;
        $this->saveFiles();
        $this->saveFields();
    }
    
   /* public function beforeFind()
    {
        foreach($this->fileFields as $field=>$params){
            $this->getOwner()->$field = $this->getImageUrl($field);
        }
    }*/
    
    public function afterDelete()
    {
        $this->deleteFiles();
    }
    
    public function saveFiles($fileName=false)
    {
        
        if($fileName) 
            $uploadedFile = CUploadedFile::getInstanceByName($fileName); //for the case if we have fileUpload field like CHtml::fileField('fileName') 
        else 
            $uploadedFile = CUploadedFile::getInstance($this->getOwner(), $this->name);
        if(!$uploadedFile) 
            return true;
        $this->uploadedFile = $uploadedFile;
        
        if(!in_array($uploadedFile->extensionName, $this->allowed)){
            Yii::app()->user->setFlash('image', 'Illegal file type');
            return false;
        }
        require_once 'phpthumb/ThumbLib.inc.php';
        foreach($this->fileFields as $field => $params){
            //resize images
            if($params){
                $file = PhpThumbFactory::create($uploadedFile->tempName);
                $method = array_shift($params);
                call_user_func_array(array($file, $method), $params);
            }else{
                $file = Yii::app()->image->load($uploadedFile->tempName);
            }
            $file->save($this->getPath($field));
        }
        return true;
    }

    private function saveFields()
    {
        $model = $this->owner->isNewRecord 
            ? $this->owner->findByPk($this->owner->getOldPrimaryKey())
            : $this->owner;
        foreach ($this->fileFields as $field=>$params){
            if(!$this->has($field))
                continue;

            $url = $this->getImageUrl($field, true);
            if($model->$field != $url)
                $model->$field = $url;            
        }
        $this->mode = false;
        $model->save();
    }
    
    public function getPath($field)
    {   $s = DIRECTORY_SEPARATOR;
        $path = Yii::getPathOfAlias('webroot.files'. $s. $this->modelName);
        if(!file_exists($path)) 
            mkdir($path, 0777);
        $path .= $s. $field;
        if(!file_exists($path)) 
            mkdir($path, 0777);
        return $path. $s. $this->fileName;
    }

    public function getImageUrl($field, $new=false)
    {
        $model = $this->getOwner();
        if($this->has($field) && !$new)
            return $model->$field;
        
        $path = '/files/' . $this->modelName . '/' . $field .  '/' . $this->getFileName(false);
        
        foreach($this->allowed as $ext){
            if(file_exists(Yii::getPathOfAlias('webroot') . $path. '.'. $ext))
                return $path. '.'. $ext;
        }
        return '/files/' . $this->modelName . '/' . $field .  '/' . $this->noimage;
    }    
    
    public function deleteFiles()
    {
        foreach($this->fileFields as $field => $params){
            $path = $this->getPath($field);                
            if(file_exists($path)){
                unlink($path);
            }
        } 
    }

    public function getFileName($extension=true)
    {
        $model = $this->getOwner();
        if($this->nameField){
            $field = $this->nameField;
            if($this->has($field))
                $name = $model->$name;
        }else if($this->uploadedFile){
            $field = key($this->fileFields);
            if($this->has($field)){
                $name = reset(explode('.', $this->uploadedFile->name));
                $this->extension = $this->uploadedFile->extensionName;
            }
        }
        if(!isset($name))
            $name = $model->primaryKey;
        $name = $this->name.'_'.$name;
        return $extension ? $name. '.'. $this->extension : $name;
    }
    
    public function getExists($path=false)
    {
        $field = key($this->fileFields);
        $path = $path ? $path : $this->getImageUrl($field); 
        return (strpos($path, $this->noimage) === false);
    }
    
    private function has($field)
    {
        return in_array($field,  $this->getOwner()->safeAttributeNames);
    }
    
    public function getFull()
    {
        return $this->getImageUrl('full');
    }

    public function getThumb1()
    {
        return $this->getImageUrl('thumb1');
    }
    
    public function getThumb2()
    {
        return $this->getImageUrl('thumb2');
    }
    
    public function getThumb3()
    {
        return $this->getImageUrl('thumb3');
    }
    
    public function getThumb4()
    {
        return $this->getImageUrl('thumb4');
    }
        
    public function getThumb5()
    {
        return $this->getImageUrl('thumb5');
    }
    
    public function getModelName()
    {
        return get_class($this->getOwner());
    }
}