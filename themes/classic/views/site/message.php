<?php if(Yii::app()->user->hasFlash('contact')):?>
<p class="send success">
    <?php echo Yii::app() -> user -> getFlash('contact');?>
</p>
<?php else:?>
<div class="block_form faq_block black small popup">
    
	<div class="name pfdintextcondpro">Задать вопрос</div>
	<?php echo CHtml::beginForm('', 'post', array('id'=>'message_request')); ?>
        <div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'name');?> </div>
            <div class="bl-val"> <?php echo CHtml::activeTextField($model, 'name', array('class'=>'text'));?> </div>
        </div>   
        <div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'email');?> </div>
            <div class="bl-val"> <?php echo CHtml::activeTextField($model, 'email', array('class'=>'text'));?> </div>
        </div>
        <div class="cf">
            <div class="bl-name"> <?php echo CHtml::activeLabel($model, 'message');?> </div>
            <div class="bl-val"> <?php echo CHtml::activeTextArea($model, 'message');?> </div>
        </div>
        <div class="cf">
				<div class="bl-name"><lable class="prim">Решить</lable></div><div class="bl-val"><input class="otv"></input><lable style="padding-left:5px;">После ответа нажмите</lable></div>
			<!--<div class="g-recaptcha" data-sitekey="6LccdRQUAAAAAFM6MuELMCgN0yu576TtzcMQhCYi"></div>-->
		</div>
		<div class="row">
            <div class="mybutton">
                <?php echo CHtml::htmlButton('Задать вопрос',
                    array('type' => 'submit',
                          'title' => 'Задать вопрос',
						  'class' => 'center mini')); ?>
            </div>
        </div>
		<?php echo CHtml::endForm();?>
	<script>
	$(document).ready(function(){
		$('.mybutton').hide();
		var t = Math.floor(Math.random()*10);
		var v = Math.floor(Math.random()*10);
		var i = t+v;
		$('.prim').text(t+'+'+v+'=?');
		$('.otv').change(function(){
			var ty = $('.otv').val();
			if(ty == i){
					$('.mybutton').show();
					$('#cboxLoadedContent').css({'height':'380px'});
				}
		})
	});
	$(document).ready(function() {
		  $('#message_request').keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
		  }
	   });
	});
	</script>
</div>   
<?php endif;?>

 