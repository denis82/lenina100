<?php
    $this->clips['title'] = 'Редактирование';
    $this->renderPartial('_form', array('model' => $model));
?>

<!--<h3>Авторизация через соц.сети</h3>
<ul>
<?php

foreach ($model->authServices as $service) {
    echo "<li>{$service->servicename}</li>";
}

?>
</ul>-->
