
<?php var_dump($_POST); exit(); ?>

<?php
var_dump($_POST); exit();
$this->widget('CFlexWidget', array(
	'baseUrl'=>Yii::app()->baseUrl.'/manager/bin',
	'name'=>'manager',
	'width'=>'100%',
	'height'=>'100%',
	'flashVars'=>array(
		'wsdl'=>$this->createUrl('file/file'),
	)
)); 

?>
