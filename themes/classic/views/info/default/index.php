<?php 
$options = (($dataProvider->totalItemCount)/($dataProvider->pagination->pageSize) > 8 ) ? 
array(
				'cssFile'=>false,
				'header'=>'<div class="name">Страницы:</div>',
				'prevPageLabel'=>'Назад',
				'nextPageLabel'=>'Далее'
		) :
array(
				'cssFile'=>false,
				'header'=>'<div class="name">Страницы:</div>',
				'prevPageLabel'=>false,
				'nextPageLabel'=>false,
		) ;
$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'itemView',
		'itemsTagName'=>'div',
		'itemsCssClass'=>'items',
		'cssFile'=>false,
		'summaryText'=>false,
		'pager'=>$options,
)); 
?>
