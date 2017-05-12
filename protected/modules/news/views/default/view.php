<?php

$this->clips['title'] = $model['title'];

echo '<p><em>'.Yii::app()->dateFormatter->format('d MMMM yyyy', $model['create_time']) . '</em></p>';
echo $model['content'];

?>
