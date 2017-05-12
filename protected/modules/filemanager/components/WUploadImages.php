<?php

/**
 * Виджет для загрузки нескольких изображений и отображение загруженного результата.
 * Для его использования необходимо определить в модели, в которую необходиом
 * загрузить изображения, поле, в которое будет передан массив с путями до
 * изображения.
 * Это еще очень сырая предварительная версия. В последующем данный виджет
 * будет доработан и улучшен.
 */

class WUploadImages extends CInputWidget
{
    public function init()
    {
        if (isset($this->model->{$this->attribute}) ) {
            $this->value = $this->model->{$this->attribute};
        }
        
        Yii::app()->clientScript
            ->registerScriptFile($this->assetPath.'/plupload.js')
            ->registerScriptFile($this->assetPath.'/plupload.html5.js')
            ->registerScript($this->id, $this->script);
    }
    
    public function run()
    {
        if (empty($this->model->{$this->attribute})) {
            echo '<p>Пока нет изображений</p>';
        } else {
            foreach ($this->model->{$this->attribute} as $i=>$value) {
                echo CHtml::tag('div', array(
                            'style' => 'float: left;padding: 5px; margin: 5px; border: 1px solid black;',
                        ), CHtml::image(CHtml::normalizeUrl(array('/filemanager/uploader/show', 'filename'=>$value))));
            }
        }
            
        list($name, $id) = $this->resolveNameID();
        ?>
        <div id="<?php echo $this->id; ?>_list" class="items">
            <?php echo CHtml::hiddenField(CHtml::activeName($this->model, $this->attribute).''); ?>
        </div>
        <br clear="all"/>
        <a id="<?php echo $this->id; ?>_browse">Выбрать фотографии</a>
        <style type="text/css">
            #<?php echo $this->id; ?>_list {
                overflow: hidden;
            }
            #<?php echo $this->id; ?>_browse {
                display: block;
                padding-left: 208px;
            }
        </style>
        <?php /*
        <script type="text/javascript">
            <?php echo $this->getScript(); ?>
        </script>*/ ?>
        <?php
        //<a id="<?php echo $this->id; >_upload">Начать загрузку</a>
    }
    
    public function getScript()
    {
        $script = file_get_contents(dirname(__FILE__).'/WUploadImages.js');
        
        $script = strtr($script, array(
            '{{id}}' => $this->id,
            '{{url}}' => CHtml::normalizeUrl(array('/filemanager/uploader/upload')),
            '{{show_url}}'=> CHtml::normalizeUrl(array('/filemanager/uploader/show')),
            '{{input_name}}' => CHtml::activeName($this->model, $this->attribute),
            '{{asset_path}}' => $this->getAssetPath(),
        ));
        
        return $script;
    }
    
    private $_assetPath = null;
    public function getAssetPath()
    {
        if ( $this->_assetPath === null ) {
            $path = Yii::getPathOfAlias('filemanager.assets.plupload');
            $this->_assetPath = CHtml::asset($path);
        }
        
        return $this->_assetPath;
    }
}