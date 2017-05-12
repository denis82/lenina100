<?php

/**
 * This is the model class for table "{{banner_items}}".
 *
 * The followings are the available columns in table '{{banner_items}}':
 * @property integer $id
 * @property integer $banner_id
 * @property integer $create_time
 * @property integer $update_time
 * @property string $min_image_url
 * @property string $full_image_url
 * @property string $image_description
 * @property string $num
 * @property string $banner_url
 */
class BannerItem extends CActiveRecord
{
    
    public $image;
    
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return BannerItem the static model class
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
		return '{{banner_items}}';
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
			array('banner_id', 'required'),
			array('banner_id, create_time, update_time, num', 'numerical', 'integerOnly'=>true),
			array('min_image_url, full_image_url, image_description', 'length', 'max'=>255),
			array('create_time, update_time, banner_url, image_description', 'safe'),
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
			'banner' => array(self::BELONGS_TO, 'Banner', 'banner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'banner_id' => 'Banner',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'min_image_url' => 'Min Image Url',
			'full_image_url' => 'Full Image Url',
			'image_description' => 'Подпись к баннеру',
			'image' => 'Изображение',
			'num' => 'номер',
		);
	}

    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        
        $this->image = CUploadedFile::getInstance($this, 'image');
        $this->createDirectories('banner');

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
                $fullPath = Yii::getPathOfAlias('webroot.files.banner.full') . DIRECTORY_SEPARATOR . $fileName;
                
                $fullSize = Yii::app()->image->load($this->image->tempName);
                $fullSize->save($fullPath);
                $this->full_image_url = $this->getFileUrl($fullPath);
                
                $fullSize = Yii::app()->image->load($this->image->tempName);
                $minPath = Yii::getPathOfAlias('webroot.files.banner.min') . DIRECTORY_SEPARATOR . $fileName;
                $minSize = $this->resizeImage(96, 96, $fullSize);
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
}