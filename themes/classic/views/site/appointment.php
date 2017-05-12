<?php if(Yii::app()->user->hasFlash('contact')):?>
<p class="send success">
    <?php echo Yii::app() -> user -> getFlash('contact');?>
</p>
<?php else:?>
<div class="block_form faq_block black small popup">
	<div class="name pfdintextcondpro">Запись на прием</div>
	<?php echo CHtml::beginForm('', 'post', array('id'=>'message_appointment')); ?>
        <div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'name');?> </div>
            <div class="bl-val"> <?php echo CHtml::activeTextField($model, 'name', array('class'=>'text'));?> </div>
        </div>
		<div class="cf">
            <div class="bl-name black small"> <?php echo CHtml::activeLabel($model, 'sex');?> </div>
			<div class="bl-val">
				<?php echo CHtml::activeRadioButtonList($model, 'sex', array(1=>'Мужской', 2=>'Женский'), array('uncheckValue'=>0, 'template' => '{label} {input}','separator' => ''));?>
			</div>
        </div> 
        <div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'born_date');?> </div>
			<div class="bl-val"> <?php $this->widget( 'ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
				'model' => $model, // Your model
				'attribute' => 'born_date', // Attribute for input
				'htmlOptions' => array('class' => 'date_picker text'),
			)); ?> </div>
        </div>
		<div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'phone');?> </div>
            <div class="bl-val"> <?php echo CHtml::activeTextField($model, 'phone', array('class'=>'text'));?> </div>
        </div>
		<div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'service');?> </div>
            <div class="bl-val"> <?php echo CHtml::activeTextField($model, 'service', array('class'=>'text'));?> </div>
        </div>
		<div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'date');?> </div>
			<div class="bl-val"> <?php $this->widget( 'ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
				'model' => $model, 		// Your model
				'attribute' => 'date', 	// Attribute for input
				'htmlOptions' => array('class' => 'datatime text'),
			)); ?> </div>
        </div>
        <div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'comment');?> </div>
            <div class="bl-val"> <?php echo CHtml::activeTextArea($model, 'comment');?> 
        
				<label class="obr"> 
					<?php echo CHtml::activeCheckBox($model, 'sub');?>
					<?php echo CHtml::activeLabel($model, 'sub');?> 
				</label>
			</div>
        </div>
		<div id='appointment'> </div>
        <?php echo CHtml::htmlButton('Отправить сообщение',
			array('type' => 'submit',
				'title' => 'Отправить сообщение',
				'class' => 'red center'
			));
		?>
    <?php echo CHtml::endForm();?>
</div> 
<?php endif;?>

 