<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'banner',
    'type' => 'vertical',
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
	<fieldset>
		<?php 
			$text = ($model->banner_id == 2) ? 'размер баннеров должен быть: 264 х 108' : '' ;
		?>
		<p> <?php echo $text; ?></p>
        <?php echo $form->fileFieldRow($model, 'image'); ?>
		<div class="clearfix"><?php echo CHtml::image($model->min_image_url); ?></div>
		
		<div class="control-group">
			<div class="controls">
				<?php echo $form->textFieldRow($model, 'banner_url')?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls">
				<?php echo $form->textFieldRow($model, 'num')?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::activeLabelEx($model, 'image_descriprion'); ?>
			<div class="controls">
				<?php $this->widget("application.extensions.ckeditor.CKEditorWidget",
				array(
					'model'=>$model,
					'attribute'=>'image_description',
					'editorOptions'=>array(
						'resize_dir'=>'vertical',
						'height'=>'400',
						'width' => '800',
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
