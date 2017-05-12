<?php

Yii::import('users.models.User');

class AdminController extends EAdminController
{
    
    public $layout = 'admin';
    
    protected $rootDir;
    
    protected $extensions = array(
        'png' => 'image',
        'jpg' => 'image',
        'bmp' => 'image',
        'gif' => 'image',
        'doc' => 'office-doc'
    );

    public function filters() {
        return array(
            'accessControl'
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                  'roles' => array('root', 'filemanager.admin')),
            array('allow',
                  'actions'=>array('upload'),
                  'users' => array('*')),
            array('deny', 'users' => array('*')),
        );
    }
	
	public function actions()
	{
		return array(
			'fileManager' => 'filemanager.extensions.elfinder.ElFinderAction',
		);
	}

    public function actionIndex() {
        if (isset($_GET['CKEditor']))
            $this->layout = "embed";

        $this->breadcrumbs = array(
            'Файловый менеджер',
        );
        $this->render('index');
    }

    public function actionUpload() {
        $file = CUploadedFile::getInstanceByName('file');
        $path = Yii::getPathOfAlias("webroot." . $_POST['path']);
        $file->saveAs($path . DIRECTORY_SEPARATOR . $file->getName());
        echo "1";
    }

    public function actionList() {
        if (isset($_GET['CKEditor']))
            $this->layout = "embed";
        
        $filesPath = str_replace('|', '.', $_GET['path']);
        $this->rootDir = Yii::app()->file->set('webroot')->realPath;

        $directory = Yii::app()->file->set('webroot.' . $filesPath);
        $url = Yii::app()->request->baseUrl;
        $files = array();
        if ($directory->contents != false) {
            foreach ($directory->contents as $file) {
                $item = Yii::app()->file->set($file);
                if ($item->isfile) {
                    $fileItem = array();
                    $fileItem['url'] = $this->getUrl($file);
                    $fileItem['path'] = $this->getPath($file);
                    $fileItem['ext'] = $item->extension;
                    $fileItem['class'] = $this->getExt($item->extension);
                    $fileItem['label'] = $item->basename;
                    $fileItem['size'] = $item->size;
                    $files[] = $fileItem;
                }
            }
        }

        $dataProvider = new CArrayDataProvider($files, array(
                    'keyField' => 'url',
                    'pagination' => false,
                    'sort' => array(
                        'defaultOrder' => 'label ASC',
                        'attributes' => array('size', 'label', 'ext'),
                    )
                ));

        $this->render('list', array('dataProvider' => $dataProvider, 'dirPath' => $filesPath));
    }

    public function actionResize() {
        $model = new ImageModel;
        $this->layout = false;

        $dir = strrpos($_GET['path'], "|");
        $dirName = str_replace("|", DIRECTORY_SEPARATOR, substr($_GET['path'], 0, $dir));
        $filePath = substr($_GET['path'], $dir + 1);
        $image = Yii::app()->image->load(Yii::app()->file->set($dirName)->realPath . DIRECTORY_SEPARATOR . $filePath);

        if (isset($_POST['ImageModel'])) {
            $model->attributes = $_POST['ImageModel'];
            if ($model->validate()) {
                if (!empty($_GET["CKEditorFuncNum"])) {
                    echo str_replace("'", "\"", CJavaScript::encode(array('url' => $model->url)));
                } else {
                    echo $model->html;
                }
            } else {
                $this->renderPartial('resize', array('model' => $model));
            }
        } else {
            $this->renderPartial('resize', array('model' => $model, 'image' => $image));
        }
    }

    public function actionDeleteFile() {
        $count = substr_count($_GET['path'], '.') - 1;
        $dirPath = preg_replace("/\|/", DIRECTORY_SEPARATOR, $_GET['path']);
        $file = Yii::app()->file->set($dirPath);
        $file->delete(true);
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionDeleteDir() {
        $file = Yii::app()->file->set("webroot." . str_replace("|", '.', trim($_GET['path'])));
        $file->delete(true);
        Yii::app()->cache->delete("FileTreeWidget");
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionCreateDir() {
        $this->layout = false;
        if (!isset($_POST['dirName']) || !isset($_GET['path'])) {
            $this->render('createDir');
        } else {
            $dir = Yii::app()->file->set(str_replace("|", DIRECTORY_SEPARATOR, trim($_GET['path'])) . DIRECTORY_SEPARATOR . trim($_POST['dirName']));
            $dir->createDir(0777);
            Yii::app()->cache->delete("FileTreeWidget");
            if (isset($_GET['CKEditor'])) {
                $this->redirect($this->createUrl('list',
                                array('path' => $_GET['path'],
                                    'CKEditor' => $_GET['CKEditor'],
                                    'CKEditorFuncNum' => isset($_GET["CKEditorFuncNum"]) ? $_GET["CKEditorFuncNum"] : "")));
            } else {
                $this->redirect($this->createUrl('list', array('path' => $_GET['path'])));
            }
        }
    }

    protected function getExt($extension) {
        return array_key_exists(strtolower($extension), $this->extensions) ? $this->extensions[strtolower($extension)] : 'undefinaed';
    }

    protected function getLabel($path) {
        $pos = strrpos($path, DIRECTORY_SEPARATOR);
        return substr($path, $pos + 1);
    }

    protected function getUrl($path) {
        return str_replace(DIRECTORY_SEPARATOR, '/', str_replace($this->rootDir, '', $path));
    }

    protected function getPath($path) {
        return str_replace(DIRECTORY_SEPARATOR, '|', str_replace($this->rootDir . DIRECTORY_SEPARATOR, '', $path));
    }

}
