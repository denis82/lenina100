<?php
$this->widget('FileBrowser',array(
	'options' => array(
		'root' => Yii::getPathOfAlias('webroot.files'),
		'url' => Yii::app()->createUrl('/filemanager/admin/fileManager'),
		'editorCallback'=>'js:function(url) {
	        var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
	        window.opener.CKEDITOR.tools.callFunction(funcNum, url);
	        window.close();
	    }',
	    'lang' => 'ru'
	),
)); 
?>
