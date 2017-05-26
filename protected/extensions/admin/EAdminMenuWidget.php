<?php

class EAdminMenuWidget extends CWidget
{
    public function run()
    {
        if (Yii::app()->user->isGuest) {
            $profileText = 'Гость';
        } else {
            $profileText  = '<span class="brand" style="padding-top: 12px; font-size: 14px; float: left">'.Yii::app()->user->name.'</span>';
            $profileText .= $this->widget('bootstrap.widgets.BootMenu', array(
                'items' => array(
                    array('label' => 'Профиль', 'url' => array('/users/admin/update', 'id' => Yii::app()->user->model->id)),
                    array('label' => 'Выход', 'url' => array('/users/admin/logout')),
                ),
            ), true);
        }

        $this->widget('bootstrap.widgets.BootNavbar', array(
            'fixed' => true,
            'fluid' => true,
            'brand' => Yii::app()->name,
            'brandUrl' => '/',
            'brandOptions'=>array('target'=>'_blank'),
            'collapse' => true,
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.BootMenu',
                    'items' => $this->getItems(),
                ),
                array(
                    'class' => 'bootstrap.widgets.BootMenu',
                    'htmlOptions' => array('class' => 'pull-right'),
                    'items' => array(
                        array(
                            'label' => Yii::app()->user->name,
                            'url' => '#',
                            'items' => array(
                                array('label' => 'Профиль', 'icon' => 'user', 'url' => array('/profile')),
                                array('label' => 'Выход', 'icon' => '', 'url' => array('/users/default/logout')),
                            ),
                        ),
                    ),
                ),
            ),
        ));

        //$this->widget('zii.widgets.CMenu', array('items' => $this->getItems()));
    }

    private function getItems()
    {
        $items = array();
        foreach (Yii::app()->getModules() as $m => $item) {
            $module = Yii::app()->getModule($m);
            if ($module && isset($module->label)) {
            
                $url = array("/$m/admin/index");
                $items[] = array(
                    'label' => $module->label,
                    'visible' => Yii::app()->user->checkAccess($m.'.admin') || Yii::app()->user->checkAccess('root'),
                    'url' => $url,
                    'active' => $this->isActive($url),
                );
            }
        }
       
	
	
        return $items;
    }

    private function isActive($url)
    {
        if (is_array($url)) {
            $route = trim($url[0], '/');
            $routes = explode('/', $route);
            $module = $routes[0];
        }

        if ($this->controller->module !== null && $this->controller->module->id == $module && $this->controller->id == 'admin') {
            return true;
        }

        return false;
    }
}
