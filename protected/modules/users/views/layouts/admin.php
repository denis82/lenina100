<?php
$this->beginClip('sidebar');

    $this->widget('ext.bootstrap.widgets.BootMenu', array(
        'type' => 'list',
        'items' => array(
            //array('label' => 'LIST HEADER', 'itemOptions' => array('class' => 'nav-header')),
            array('label' => 'Список', 'icon' => 'th-list', 'url' => array('/users/admin/index')),
            array('label' => 'Создать', 'icon' => 'plus', 'url' => array('/users/admin/create')),

            //array('label' => '', 'itemOptions' => array('class' => 'nav-header')),
            //array('label' => 'Письма', 'icon' => 'envelope', 'url' => array('/users/admin/letters')),

            array('label' => 'Доступ', 'itemOptions' => array('class' => 'nav-header')),
            array('label' => 'Роли', 'icon' => 'cog', 'url' => array('/users/admin/roles'),
                'active' => ($this->route == 'users/admin/roles' || $this->route == 'users/admin/updateRole'),
            ),
            array('label' => 'Создать роль', 'icon' => 'plus', 'url' => array('/users/admin/createRole')),
        ),
    ));

$this->endClip();
?>

<?php echo $content; ?>
