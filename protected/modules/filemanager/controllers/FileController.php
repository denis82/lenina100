<?php

class FileController extends CController {

    private $filesPath;

    public function actions() {
        return array(
            'file' => array(
                'class' => 'CWebServiceAction'
            )
        );
    }

    /**
     * @return array of root directory direct chiilds
     * @soap
     */
    public function getRootDirectoryListing() {
        $items['label'] = $this->getLabel(YiiBase::getPathOfAlias('webroot.files'));
        $items['path'] = YiiBase::getPathOfAlias('webroot.files');
        $items['children'] = $this->buildDirectoryListingRecursive(YiiBase::getPathOfAlias('webroot.files'));
        return $items;
    }

    /**
     * @param string path to listed directory
     * @return array of files
     * @soap
     */
    public function getDirectoryListing($path) {
        $filesPath = str_replace('protected', '', Yii::app()->basePath);
        $directory = Yii::app()->file->set($path);
        $url = Yii::app()->request->baseUrl;
        $files = array();
        if ($directory->contents != false) {
            foreach ($directory->contents as $file) {
                $item = Yii::app()->file->set($file);
                if ($item->isfile) {
                    $fileItem = array();
                    $path = str_replace($filesPath, '', $file);
                    $path = str_replace('\\', '/', $path);
                    $fileItem['path'] = $file;
                    $fileItem['url'] = $url . '/' . $path;
                    $fileItem['editorUrl'] = '/' . $path;
                    $fileItem['name'] = $item->basename;
                    $fileItem['size'] = $item->size;
                    $files[] = $fileItem;
                }
            }
        }
        return $files;
    }

    /**
     * @param string path to directory
     * @return boolean is operation successfull
     * @soap
     */
    public function removeDirectory($path) {
        $file = Yii::app()->file->set($path);
        return $file->delete(true);
    }

    /**
     * @param string path to file
     * @return boolean is operation successfull
     * @soap
     */
    public function removeFile($path) {
        $file = Yii::app()->file->set($path);
        return $file->delete();
    }

    /**
     * @param string path to parent directory path
     * @param string name subdirectory name
     * @return boolean if is directory created
     * @soap
     */
    public function createSubDirectory($path, $name) {
        $dir = Yii::app()->file->set($path . "/" . $name);
        return $dir->createDir(0777);
    }

    /**
     * @param string path to file
     * @param integer width of image
     * @param integer height of image
     * @return string resized file url
     * @soap
     */
    public function resizeImage($path, $width, $height) {
        $image = Yii::app()->image->load($path);
        $image->resize($width, $height);
        $fileName = substr($path, strrpos($path, DIRECTORY_SEPARATOR) + 1);
        $dirName = substr($path, 0, strrpos($path, DIRECTORY_SEPARATOR));
        $dir = Yii::app()->file->set($dirName . "/thumb/");
        if (!$dir->exists) {
            $dir->createDir(0777);
        }
        $image->save($dirName . "/thumb/" . $fileName);
        $filesPath = str_replace('protected', '', Yii::app()->basePath);
        return "/" . str_replace($filesPath, "", $dirName . "/thumb") . "/" . $fileName;
    }

    protected function buildDirectoryListingRecursive($path) {
        $file = Yii::app()->file->set($path);
        if ($file->isdir && !$file->isempty && $file->contents != false) {
            $files = array();
            foreach ($file->contents as $itemPath) {
                $item = Yii::app()->file->set($itemPath);
                if ($item->isdir && !count($item->contents)) {
                    $itemResult['label'] = $this->getLabel($itemPath);
                    $itemResult['path'] = $itemPath;
                    $files[] = $itemResult;
                } elseif ($item->isdir && count($item->contents)) {
                    $itemResult['label'] = $this->getLabel($itemPath);
                    $itemResult['path'] = $itemPath;
                    $itemResult['children'] = $this->buildDirectoryListingRecursive($itemPath);
                    $files[] = $itemResult;
                }
            }
            if (!empty($files)) {
                return $files;
            }
        } else {

        }
    }

    protected function getLabel($path) {
        $pos = strrpos($path, DIRECTORY_SEPARATOR);
        return substr($path, $pos);
    }

}

?>