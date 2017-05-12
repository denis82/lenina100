<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'news',
    'type' => 'vertical',
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
	<fieldset>

        <?php if($this->withCategories || $this->categories): ?>
            <?php if (!isset($_GET['category_id'])): ?>
                <?php echo $form->dropDownListRow($model, 'category_id', $model->categoryOptions); ?>
            <?php else: ?>
                <p><strong>Раздел:</strong> <?php echo $model->categoryText; ?></p>
            <?php endif; ?>            
        <?php endif; ?>


        <?php echo $form->textFieldRow($model, 'title', array('class' => 'span10')); ?>

        <?php echo $form->fileFieldRow($model, 'image'); ?>
            <div class="clearfix"><?php echo CHtml::image($model->image->thumb1); ?></div>
        
		<div class="control-group">
			<?php echo CHtml::activeLabelEx($model, 'createTime'); ?>
			<div class="controls">
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'createTime',
						'language'=>'ru',
						'htmlOptions' => array(
							'class'=>'span10',
						),
					));
				?>
			</div>
		</div>

		<div class="control-group">
			<?php echo CHtml::activeLabelEx($model, 'expireTime'); ?>
			<div class="controls">
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'expireTime',
						'language'=>'ru',
						'htmlOptions' => array(
							'class'=>'span10',
						),
					));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::activeLabelEx($model, 'annotation'); ?>
			<div class="controls">
				<?php $this->widget("application.extensions.ckeditor.CKEditorWidget",
					array(
						'model'=>$model,
						'attribute'=>'annotation',
						'editorOptions'=>array(
							'resize_dir'=>'vertical',
							'height'=>'400',
							'width' => '800',
						)
					));
				?>
				<?php echo $form->error($model,'annotation'); ?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::activeLabelEx($model, 'content'); ?>
			<div class="controls">
				<?php $this->widget("application.extensions.ckeditor.CKEditorWidget",
					array(
						'model'=>$model,
						'attribute'=>'content',
						'editorOptions'=>array(
							'resize_dir'=>'vertical',
							'height'=>'400',
							'width' => '800',
						)
					));
				?>
				<?php echo $form->error($model,'content'); ?>
			</div>
		</div>

        <!--<?php echo $form->checkBoxRow($model, 'visible_in_rss'); ?>-->
        <?php echo $form->dropDownListRow($model, 'status', $model->statusOptions); ?>

		<div class="form-actions">
		    <?php echo CHtml::htmlButton(BHtml::icon('ok white').' Сохранить', array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
			<?php echo CHtml::link(BHtml::icon('ban-circle').' Отмена',
                       array('index'),
                       array('title'=>'Отмена', 'class'=>'btn small')); ?>

		    <?php //echo CHtml::htmlButton('Отмена', array('class'=>'btn small', 'submit'=>array('index'))); ?>

		</div>
	</fieldset>
<?php $this->endWidget(); ?>
