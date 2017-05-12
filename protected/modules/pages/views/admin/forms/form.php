<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'page',
    'type' => 'vertical',
)); ?>
    <?php echo $form->errorSummary($model); ?>
    <fieldset>
    <?php $this->beginClip('_content'); ?>
        <?php echo $form->textFieldRow($model, 'content_title', array('class' => 'span10')); ?>
        <div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'content'); ?>
            <div class="controls">
                <?php $this->widget("application.extensions.ckeditor.CKEditorWidget",
                    array(
                            'model'=>$model,
                            'attribute'=>'content',
                            'editorOptions'=>array(
                                    'resize_dir'=>'vertical',
                                    'height'=>'300'
                            )
                    ));
                ?>
                <?php echo $form->error($model,'content'); ?>
            </div>
        </div>
		
		<div class="control-group">
            <?php echo CHtml::activeLabel($model, 'right_content'); ?>
            <div class="controls">
                <?php $this->widget("application.extensions.ckeditor.CKEditorWidget",
                    array(
                            'model'=>$model,
                            'attribute'=>'right_content',
                            'editorOptions'=>array(
                                    'resize_dir'=>'vertical',
                                    'height'=>'300'
                            )
                    ));
                ?>
                <?php echo $form->error($model,'right_content'); ?>
            </div>
        </div>
		
		<?php echo $form->textFieldRow($model, 'symbol_separator', array('class' => 'span10')); ?>
		<div class="control-group">
            <?php echo CHtml::activeLabel($model, 'price_content'); ?>
            <div class="controls">
                <?php $this->widget("application.extensions.ckeditor.CKEditorWidget",
                    array(
                            'model'=>$model,
                            'attribute'=>'price_content',
                            'editorOptions'=>array(
                                    'resize_dir'=>'vertical',
                                    'height'=>'300'
                            )
                    ));
                ?>
                <?php echo $form->error($model,'price_content'); ?>
            </div>
        </div>
    <?php $this->endClip(); ?>

    <?php $this->beginClip('_params'); ?>
        <?php echo $form->textFieldRow($model, 'page_title', array('class' => 'span10')); ?>
        <?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span10')); ?>
        <?php echo $form->textFieldRow($model, 'description', array('class' => 'span10')); ?>
        <?php echo $form->textFieldRow($model, 'label', array('class' => 'span10 link')); ?>
        <?php if ($model->level > 1 || $model->isNewRecord) echo $form->textFieldRow($model, 'name', array('class' => 'span10 link')); ?>
        <?php echo $form->textFieldRow($model, 'layout', array('class' => 'span10')); ?>
        <?php echo $form->checkBoxRow($model, 'is_visible', array('class' => 'link')); ?>
        <?php if ($model->level > 1 || $model->isNewRecord)
              echo $form->checkBoxRow($model, 'type', array('class' => 'link')); ?>
    <?php $this->endClip(); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootTabbed', array(
            'type' => 'tabs',
            'tabs' => array(
                array('label' => 'Home', 'content' => $this->clips['_content']),
                array('label' => 'Параметры', 'content' => $this->clips['_params']),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(BHtml::icon('ok white').' Сохранить', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
            <?php echo CHtml::link(BHtml::icon('ban-circle').' Отмена',
               array('index'),
               array('title'=>'Отмена', 'class'=>'btn small')); ?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>

<?php $cs = Yii::app()->clientScript->registerScript('hideRows', '
        if($("input#Page_type").is(":checked")) {
            $(".nav-tabs li:last-child a").click()
            $(".tab-content div:first-child > *, .nav-tabs li:first-child").hide();
        }
        $("input#Page_type").bind("change", function(){
            console.log($(this).is(":checked"))
            if($(this).is(":checked")) {
                $(".tab-content div:first-child > *, .nav-tabs li:first-child").hide();
            } else {
                $(".nav-tabs li:first-child, .tab-content div:first-child > *").show();
            }
        });
    ');
?>
