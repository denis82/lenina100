<?php

$auths = array();
foreach (Yii::app()->getModules() as $i=>$m) {
    $module = is_numeric($i) ? $m : $i;
    $moduleClass = Yii::app()->getModule($module);
    if($moduleClass && isset($moduleClass->label) && !isset($moduleClass->rootOnly)){
        $moduleRus = isset($moduleClass->label) ? $moduleClass->label : $module;
        $auths[$module.'.admin'] = array(
            'type' => CAuthItem::TYPE_TASK,
            'description' => 'Управление модулем '.$moduleRus,
            'bizRule' => null,
            'data' => null,
        );
    }
}

return CMap::mergeArray(
    //require dirname(__FILE__).'/_auth.php',
    $auths,
    require dirname(__FILE__).'/_roles.php'
);

