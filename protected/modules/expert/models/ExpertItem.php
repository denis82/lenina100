<?php

/**
 * This is the model class for table "{{expert_items}}".
 *
 * The followings are the available columns in table '{{expert_items}}':
 * @property integer $id
 * @property integer $expert_id
 * @property integer $create_time
 * @property integer $update_time
 * @property string $min_image_url
 * @property string $mid_image_url
 * @property string $full_image_url
 * @property string $image_description
 * @property string $name
 */
class ExpertItem extends CActiveRecord
{
    
    public $image;
    
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return ExpertItem the static model class
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
		return '{{expert_items}}';
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('expert_id, image_description, name', 'required'),
			array('expert_id, create_time, update_time', 'numerical', 'integerOnly'=>true),
			array('min_image_url, mid_image_url, full_image_url, image_description, name', 'length', 'max'=>255),
			array('create_time, update_time, view', 'safe'),
			array('image', 'file', 'types' => 'jpeg, gif, png, jpg', 'allowEmpty'=>true),
			array('image', 'required', 'on'=>self::SCENARIO_CREATE),
		);
	}
    
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'expert_id' => 'Expert',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'min_image_url' => 'Min Image Url',
			'mid_image_url' => 'Mid Image Url',
			'full_image_url' => 'Full Image Url',
			'image_description' => 'Дополнительная информация',
			'image' => 'Фотография',
			'name' => 'ФИО сотрудника',
			'view' => 'Видимость',
		);
	}

    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        
        $this->image = CUploadedFile::getInstance($this, 'image');
        $this->createDirectories('expert');

        return true;
    }
    
    protected function afterValidate()
    {
        parent::afterValidate();
        
        if (!$this->hasErrors()) {
            if ((!empty($this->min_image_url) || !empty($this->full_image_url)) &&
                !empty($this->image)) {
                    $this->deleteImages();
            }
            if (!empty($this->image)) {
                $salt = substr(md5_file($this->image->tempName), 0, 10);
                $originalName = str_replace('.' . $this->image->extensionName, '', $this->image->name);
				$originalName = str_replace(" ", "", H::translit($originalName));
                $fileName = $originalName . '_' . $salt . '.' . strtolower($this->image->extensionName);
                $fullPath = Yii::getPathOfAlias('webroot.files.expert.full') . DIRECTORY_SEPARATOR . $fileName;
                
                $fullSize = Yii::app()->image->load($this->image->tempName);
                $fullSize->save($fullPath);
                $this->full_image_url = $this->getFileUrl($fullPath);
                
                $fullSize = Yii::app()->image->load($this->image->tempName);
                $midPath = Yii::getPathOfAlias('webroot.files.expert.mid') . DIRECTORY_SEPARATOR . $fileName;
                $midSize = $this->resizeImage(133, 159, $fullSize);
                $midSize->save($midPath);
                $this->mid_image_url = $this->getFileUrl($midPath);
				
				$fullSize = Yii::app()->image->load($this->image->tempName);
                $minPath = Yii::getPathOfAlias('webroot.files.expert.min') . DIRECTORY_SEPARATOR . $fileName;
                $minSize = $this->resizeImage(20, 20, $fullSize);
                $minSize->save($minPath);
                $this->min_image_url = $this->getFileUrl($minPath);
            }
        }
        
    }
    
    protected function createDirectories($rootDirName)
    {
        $rootPath = "webroot.files.{$rootDirName}";
        $minPath = $rootPath . '.min';
        $fullPath = $rootPath . '.full';
        
        $rootDir = Yii::app()->file->set(Yii::getPathOfAlias($rootPath));
        $minDir = Yii::app()->file->set(Yii::getPathOfAlias($minPath));
        $fullDir = Yii::app()->file->set(Yii::getPathOfAlias($fullPath));
        
        if (!$rootDir->isDir) {
            $rootDir->createDir(0755);
        }
        if (!$minDir->isDir) {
            $minDir->createDir(0755);
        }
        if (!$fullDir->isDir) {
            $fullDir->createDir(0755);
        }
    }
    
    protected function resizeImage($width, $height, $image) {
        $scaleRatio = $width / $image->width;
        $from = $height / $width;
        $to = $image->height / $image->width;
        
        if ($from >= $to) {
            $w = $image->height * $width / $height;
            $h = $image->height;
        } else if ($from < $to) {
            $h = $image->width * $height / $width;
            $w = $image->width;
        }
        
        $image->crop($w, $h);
        $image->resize($width, $height);

        return $image;
    }
    
    protected function afterDelete()
    {
        parent::afterDelete();
        $this->deleteImages();
    }
    
    public function deleteImages() 
    {
        $this->deleteImage($this->min_image_url);
		$this->deleteImage($this->mid_image_url);
        $this->deleteImage($this->full_image_url);
    }
    
    protected function deleteImage($url)
    {
        $file = Yii::app()->file->set(Yii::getPathOfAlias('webroot') . str_replace('/', DIRECTORY_SEPARATOR, $url));
        if ($file->isFile) {
            $file->delete();
        }
    }
    
    protected function getFileUrl($path)
    {
        $basePath = Yii::getPathOfAlias('webroot');
        return str_replace(DIRECTORY_SEPARATOR, '/', str_replace($basePath, '', $path));
    }
	
	public static function getExpert() 
    {
        return self::model()->findAll();
    }
}