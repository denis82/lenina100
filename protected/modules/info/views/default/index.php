<?php 
$this->clips['title'] = $page['page_title'];
$this->clips['keywords'] = $page['keywords'];
$this->clips['description'] = $page['description'];
?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'summaryText' => '',
)); ?>
