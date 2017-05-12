<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileTreeWidget
 *
 * @author V
 */
class FileTreeWidget extends CWidget {

    private $level = 1;
    private $items = array();
    private $rootDir;

    public function init() {
        $this->items = Yii::app()->cache->get("FileTreeWidget");

        if(!$this->items) {
            $this->rootDir = Yii::app()->file->set('webroot')->realPath;
            $item['label'] = $this->getLabel(Yii::getPathOfAlias('webroot.files'));
            $item['level'] = $this->level;
            $item['path'] = $this->getPath(Yii::app()->file->set('webroot.files')->realPath);//Yii::getPathOfAlias('webroot.files');
            $this->items[] = $item;
            $this->buildDirectoryListingRecursive(Yii::getPathOfAlias('webroot.files'), 2);

            Yii::app()->cache->set("FileTreeWidget", $this->items);
        }
    }

    protected function buildDirectoryListingRecursive($path, $level) {
        $file = Yii::app()->file->set($path);
        if ($file->isdir && !$file->isempty && $file->contents != false) {
            $files = array();
            foreach ($file->contents as $itemPath) {
                $item = Yii::app()->file->set($itemPath);
                if ($item->isdir && !count($item->contents)) {
                    $itemResult['label'] = $this->getLabel($itemPath);
                    $itemResult['path'] = $this->getPath($itemPath);
                    $itemResult['level'] = $level;
                    $this->items[] = $itemResult;
                } elseif ($item->isdir && count($item->contents)) {
                    $itemResult['label'] = $this->getLabel($itemPath);
                    $itemResult['path'] = $this->getPath($itemPath);
                    $itemResult['level'] = $level;
                    $this->items[] = $itemResult;
                    $this->buildDirectoryListingRecursive($itemPath, ++$level);
                    --$level;
                }
            }
            if (!empty($files)) {
                return $files;
            }
        } else {

        }
    }

    protected function getPath($path) {
        return str_replace(DIRECTORY_SEPARATOR, '|', str_replace($this->rootDir.DIRECTORY_SEPARATOR,'',$path));
    }

    protected function getLabel($path) {
        $pos = strrpos($path, DIRECTORY_SEPARATOR);
        return substr($path, $pos+1);
    }

    public function run() {
        $cs = Yii::app()->clientScript;
        $jsTreePath = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR."jsTree");
        $cs->registerScriptFile($jsTreePath.'/_lib/jquery.cookie.js');
        $cs->registerScriptFile($jsTreePath.'/_lib/jquery.hotkeys.js');
        $cs->registerScriptFile($jsTreePath.'/jquery.jstree.js');

        $cs->registerScript('jsTree', '
            $(".tree").jstree({
                plugins: ["themes", "cookies", "ui", "contextmenu", "html_data"],
                contextmenu: {
                    items: {
                        create: {
                            label: "Создать подкаталог",
                            icon: false,
                            action: function(obj){
                                var path = $($(obj).children("a")[0]).attr("data-path");
                                var href = "'.(isset($_GET["CKEditor"]) ? $this->controller->createUrl('createDir', array(
                                'CKEditor'=>$_GET["CKEditor"],
                                'CKEditorFuncNum'=>isset($_GET["CKEditorFuncNum"]) ? $_GET["CKEditorFuncNum"] : "","path"=>"")) : $this->controller->createUrl('createDir', array('path'=>''))).'";
                                $.ajax({
                                    url: href+path,
                                    success: function(data){
                                        $("#createDirDialog").html(data);
                                        $("#createDirDialog").dialog("open");
                                    }
                                });
                            }
                        },
                        remove: {
                            label: "Удалить директорию",
                            icon: false,
                            action: function(obj) {
                                var path = $($(obj).children("a")[0]).attr("data-path");
                                var href = "'.$this->controller->createUrl('deleteDir', array("path"=>"")).
                                '";
                                if(confirm("Вы действительно хотите удалить директорию?")) {
                                    window.location = href+path;
                                }
                            }
                        },
                        ccp: false,
                        rename: false
                    }
                },
                themes: {
                    theme: "classic",
                    url: "'.$jsTreePath.'/themes/classic/style.css"
                }
            });

            $(".tree").jstree("open_all");

            $(".tree").bind("select_node.jstree", function(event,data){
                $(".tree a").removeClass("active");
                window.location = $($(data.rslt.obj).children("a")[0]).attr("href");
            });
        ');
        
        $this->render('fileTreeWidget', array('links'=>$this->items));
    }

}

?>
