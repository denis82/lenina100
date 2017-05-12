<?php
//<script type="text/javascript">
//jQuery(function() {

$url = CHtml::normalizeUrl(array('/filemanager/uploader/upload'));
$script = <<<EOF
    uploader = new plupload.Uploader({
        runtimes: 'html4,html5',
        browse_button: '{$this->id}Browse',
        url: '{$url}'
    });
    
    uploader.bind('QueueChanged', function(up) {
        uploader.start();
    });
    
    uploader.bind('FileUploaded', function(up, files, response) {
        var r = jQuery.parseJSON(response.response);
        
        jQuery('#{$this->id} .image')
            .empty()
            .append(
                jQuery('<img />', {
                    src: r.thumb
                })
            );
        
        jQuery('#{$id}').attr('value', r.file);
    });
    
    uploader.init();
EOF;
//});
        
Yii::app()->clientScript->registerScript($this->id, $script);

//</script>
?>

<div id="<?php echo $this->id; ?>" class="WUploadImage">
    <?php echo CHtml::hiddenField($name, $this->value, array('id'=>$id)); ?>
    <?php echo CHtml::link('Выбрать фотографию', '', array('id'=>$this->id.'Browse', 'class'=>'browseButton')); ?>
    <div class="image">
        <?php
        $path = Yii::getPathOfAlias('webroot');
        if (!empty($this->value) AND file_exists($path.$this->value)) {
            echo CHtml::image(CHtml::normalizeUrl(array('/filemanager/uploader/show',
                                                        'filename' => $this->value)));
        } else {
            echo 'Нет фото';
        }
        
        ?>
    </div>
</div>
<style type="text/css">
    .WUploadImage .image img {
        border: 1px solid black;
        padding: 10px;
    }
    .browseButton {
        display: block;
        font-size: 14px;
        margin: 10px 0;
        cursor: pointer;
    }
</style>