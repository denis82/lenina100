<?php if(isset($_GET['CKEditor'])): ?>
<?php

    $this->widget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'resizeDialog',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'title'=>'Image Resize',
            'autoOpen'=>false,
            'minWidth'=>450,
            'minHeight'=>180,
            'modal'=>true
        ),
    ));
    if(isset($_GET["CKEditorFuncNum"]) && !empty($_GET["CKEditorFuncNum"])) {
        Yii::app()->clientScript->registerScript('ck', '
            $(".insert-to-ck").live("click", function(event){
                event.stopPropagation();
                event.preventDefault();

                if($($(this).parents("tr")[0]).find(".image").length == 0) {
                    window.opener.CKEDITOR.tools.callFunction('.$_GET['CKEditorFuncNum'].', $(this).attr("data-url"));
                    window.close();
                    return;
                }
                $.ajax({
                    url: $(this).attr("href"),
                    success: function(data){
                        $("#resizeDialog").html(data);
                        $("#resizeDialog").dialog("open");
                        $("#resizeDialog").find("input#ImageModel_width").live("keyup", function(){
                            var val = Math.round(parseInt($(this).val())/ratio);
                            $("#resizeDialog").find("input#ImageModel_height").val(val)
                        });
                        $("#resizeDialog").find("input#ImageModel_height").live("keyup", function(){
                            var val = Math.round(ratio*parseInt($(this).val()));
                            $("#resizeDialog").find("input#ImageModel_width").val(val)
                        });

                        var width = parseInt($("#resizeDialog").find("input#ImageModel_width").val());
                        var height = parseInt($("#resizeDialog").find("input#ImageModel_height").val());
                        var ratio = width/height;

                        $("#resizeDialog").find("input[type=submit]").live("click", function(event){
                            event.stopPropagation();
                            event.preventDefault();
                            $.ajax({
                                url: $(this).parents("form").attr("action"),
                                data: $(this).parents("form").serialize(),
                                type: "post",
                                success: function(data) {
                                    try{
                                        var json = JSON.parse(data, function (key, value) {
                                            var type;
                                            if (value && typeof value === "object") {
                                                type = value.type;
                                                if (typeof type === "string" && typeof window[type] === "function") {
                                                    return new (window[type])(value);
                                                }
                                            }
                                            return value;
                                        });

                                        window.opener.CKEDITOR.tools.callFunction('.$_GET['CKEditorFuncNum'].', json.url);
                                        window.close();
                                    }
                                    catch(e) {
                                        console.log(e);
                                        $("#resizeDialog").html(data);
                                    }
                                },
                                error: function(xhr, message, errorThrown) {
                                    alert(message);
                                }
                            });
                        });
                    }
                });

            });
        ');
    } else {
        Yii::app()->clientScript->registerScript('ck', '
            $(".insert-to-ck").live("click", function(event){
                event.stopPropagation();
                event.preventDefault();

                if($($(this).parents("tr")[0]).find(".image").length == 0) {
                    return;
                }
                $.ajax({
                    url: $(this).attr("href"),
                    success: function(data){
                        $("#resizeDialog").html(data);
                        $("#resizeDialog").dialog("open");
                        $("#resizeDialog").find("input#ImageModel_width").live("keyup", function(){
                            var val = Math.round(parseInt($(this).val())/ratio);
                            $("#resizeDialog").find("input#ImageModel_height").val(val)
                        });
                        $("#resizeDialog").find("input#ImageModel_height").live("keyup", function(){
                            var val = Math.round(ratio*parseInt($(this).val()));
                            $("#resizeDialog").find("input#ImageModel_width").val(val)
                        });

                        var width = parseInt($("#resizeDialog").find("input#ImageModel_width").val());
                        var height = parseInt($("#resizeDialog").find("input#ImageModel_height").val());
                        var ratio = width/height;

                        $("#resizeDialog").find("input[type=submit]").live("click", function(event){
                            event.stopPropagation();
                            event.preventDefault();
                            $.ajax({
                                url: $(this).parents("form").attr("action"),
                                data: $(this).parents("form").serialize(),
                                type: "post",
                                success: function(data) {
                                    if($(data).find(".error").length != 0) {
                                        $("#resizeDialog").html(data);
                                    } else {
                                        window.opener.CKEDITOR.instances["'.$_GET['CKEditor'].'"].insertHtml(data);
                                        window.close();
                                    }
                                },
                                error: function(xhr, message, errorThrown) {
                                    alert(message);
                                }
                            });
                        });
                    }
                });

            });
        ');
    }
?>
<?php endif; ?>

<?php
$this->widget('application.extensions.uploadify.EuploadifyWidget',
    array(
        'name'=>'uploadme',
        'options'=> array(
            'fileDataName'=>'file',
            'script' => $this->createUrl('upload'),
            'cancelImg' => '/css/cancel.png',
            'auto' => true,
            'multi' => true,
            'scriptData' => array('path' => $dirPath, 'PHPSESSID' => session_id(), 'YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
            'buttonText' => 'Upload',
            'width' => 150,
            ),
            'callbacks' => array(
               'onError' => 'js:function(evt,queueId,fileObj,errorObj){alert("Error: " + errorObj.type + "\nInfo: " + errorObj.info);}',
               'onAllComplete' => 'js:function(){window.location.reload();}',
            )
    ));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'summaryText'=>'Всего файлов:'.' {count}',
    'columns'=>array(
        array(
            'header'=>'Превью',
            'value'=>'$data["class"] == "image" ? CHtml::image($data["url"], "", array("class"=>"image")) : CHtml::tag("div", array("class"=>$data["class"]), "Файл .".$data["ext"])',
            'type'=>'raw',
        ),
        array(
            'header'=>'Название файла',
            'value'=>'$data["label"]',
            'name'=>'label',
        ),
        array(
            'header'=>'Тип файла',
            'value'=>'$data["ext"]',
            'name'=>'ext',
        ),
        array(
            'header'=>'Размер файла',
            'value'=>'$data["size"]',
            'name'=>'size',
        ),
        array(
            'header'=>'Вставка',
            'value'=>'CHtml::link("Вставка", Yii::app()->createUrl("/filemanager/admin/resize",
                array("path"=>$data["path"],
                "CKEditor"=>$_GET["CKEditor"],
                "CKEditorFuncNum"=>isset($_GET["CKEditorFuncNum"]) ? $_GET["CKEditorFuncNum"] : ""))
                , array("class"=>"insert-to-ck", "data-url"=>$data["url"]))',
            'visible'=>isset($_GET["CKEditor"]) ? true : false,
            'type'=>'raw',
        ),
        array(
            'header'=>'Действия',
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array(
                'delete'=>array(
                    'url'=>'$this->grid->owner->createUrl("deleteFile", array("path"=>$data["path"]))',
                ),
            ),
),
    )
)); ?>
