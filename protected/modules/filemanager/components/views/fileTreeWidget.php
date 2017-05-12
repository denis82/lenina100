<?php $currentDir = str_replace($this->controller->createUrl('list', array('path'=>'')),'', '/'.Yii::app()->request->pathInfo); ?>
<div class="tree">
    <ul>
            <?php $length = count($links); ?>

            <?php for($i=0; $i < $length; $i++): ?>
                    <?php $current = $links[$i]; $next = isset($links[$i+1]) ? $links[$i+1] : array(); ?>
                    <li>
                    <?php if(!isset($_GET['CKEditor'])): ?>
                        <?php echo CHtml::link($current['label'], array('list', 'path'=>$current['path']), array(
                            'data-path'=>$current['path'],
                            'class'=>$currentDir != $current['path'] ? '' : 'active'
                        )); ?>
                    <?php else: ?>
                        <?php echo CHtml::link($current['label'], array('list', 'path'=>$current['path'],
                                'CKEditorFuncNum'=>isset($_GET["CKEditorFuncNum"]) ? $_GET["CKEditorFuncNum"] : "",
                                'CKEditor'=>$_GET['CKEditor']),
                            array(
                                'data-path'=>$current['path'],
                                'class'=>'/'.$currentDir != $current['path'] ? '' : 'active'
                        )); ?>
                    <?php endif; ?>

                    <?php if(isset($next) && !empty($next)): ?>
                            <?php if($current['level'] > $next['level']): ?>
                                <?php echo str_repeat("</li></ul>", ($current['level'] - $next['level']))."</li>"; ?>
                            <?php elseif($current['level'] < $next['level']): ?>
                                    <ul>
                            <?php else: ?>
                                    </li>
                            <?php endif; ?>

                    <?php else: ?>
                            </li>
                    <?php endif; ?>

            <?php endfor; ?>
    </ul>
</div>
<?php
    $this->widget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'createDirDialog',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'title'=>'Создание подкаталога',
            'autoOpen'=>false,
            'minWidth'=>450,
            'minHeight'=>180,
            'modal'=>true
        ),
    ));
?>