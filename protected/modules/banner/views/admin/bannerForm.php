<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'banner',
    'type' => 'vertical',
)); ?>
  <fieldset>

    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span10')); ?>
    <?php echo $form->textFieldRow($model, 'url', array('class' => 'span10')); ?>
	
	<div class="control-group">
		<?php echo CHtml::activeLabelEx($model, 'descriprion'); ?>
		<div class="controls">
			<?php $this->widget("application.extensions.ckeditor.CKEditorWidget",
				array(
					'model'=>$model,
					'attribute'=>'description',
					'editorOptions'=>array(
						'resize_dir'=>'vertical',
						'height'=>'400',
						'width' => '800',
					)
				));
			?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	</div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(BHtml::icon('ok white').' Сохранить', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
      <?php echo CHtml::link(BHtml::icon('ban-circle').' Отмена',
                       array('index'),
                       array('title'=>'Отмена', 'class'=>'btn small')); ?>

    </div>
  </fieldset>
<?php $this->endWidget(); ?>
