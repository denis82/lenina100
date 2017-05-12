    <?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'itemView',
    'itemsTagName'=>'div',
    'itemsCssClass'=>'items',
    'cssFile'=>false,
    'summaryText'=>false,
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'<div class="name">Страницы:</div>',
        'prevPageLabel'=>'Назад',
        'nextPageLabel'=>'Далее'
    )
)); ?>
