<!--<div id="search">--> 
 <!--<div id="search_div">-->
    <div class="header-search">
    	<?php $url = $this->getController()->createUrl('/info/search'); ?>
		<?php echo CHtml::beginForm($url); ?>
		<div class="row">
		 <!--<input type="text" class="input-search-header" id="header-search" name="header-search" placeholder="Поиск">-->
		<?php echo CHtml::activeTextField($form,'string' , array('class'=>"input-search-header", 'id'=>"header-search", 'placeholder'=>"Поиск")) ?>
		<?php echo CHtml::error($form,'string'); ?>
		<?php echo CHtml::SubmitButton('Поиск',array('class'=>'header-search__submit')); ?>
		</div>
		<?php echo CHtml::endForm(); ?>
    <!--</div>-->
    <div id="SearchFooter"></div>
</div>
