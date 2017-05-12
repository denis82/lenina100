<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'expert',
    'type' => 'vertical',
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
	<fieldset>

    <?php echo $form->fileFieldRow($model, 'image'); ?>
    <div class="clearfix"><?php echo CHtml::image($model->mid_image_url); ?></div>

		<div class="control-group">
            <?php echo CHtml::activeLabelEx($model, 'name');?>
			<div class="controls">
				<?php echo CHtml::activeTextField($model, 'name', array('size' => '300'));?>
			</div>
    </div>
		
		<?php echo $form->checkBoxRow($model, 'view', array('class' => 'link')); ?>
		
		<div class="control-group">
			<?php echo CHtml::activeLabelEx($model, 'image_description'); ?>
			<div class="controls">
				<?php $this->widget("application.extensions.ckeditor.CKEditorWidget",
					array(
						'model'=>$model,
						'attribute'=>'image_description',
						'editorOptions'=>array(
							'resize_dir'=>'vertical',
							'height'=>'400'
						)
					));
				?>
				<?php echo $form->error($model,'image_description'); ?>
			</div>
		</div>
				
		

		<div class="form-actions">
		    <?php echo CHtml::htmlButton(BHtml::icon('ok white').' Сохранить', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
			<?php echo CHtml::link(BHtml::icon('ban-circle').' Отмена',
                       array('index'),
                       array('title'=>'Отмена', 'class'=>'btn small')); ?>

		    <?php //echo CHtml::htmlButton('Отмена', array('class'=>'btn small', 'submit'=>array('index'))); ?>

		</div>
	</fieldset>
<?php $this->endWidget(); ?>
