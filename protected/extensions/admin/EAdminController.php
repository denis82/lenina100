<?php

class EAdminController extends CController
{
    public $layout = 'admin';
    public $breadcrumbs = array();
    public $menu;

    public function filters()
    {
        return array(
            'accessControl'
        );
    }

    public function accessRules()
    {
        $allow = array();
        $allow[] = 'root';
        if (isset($this->module->id)) {
            $allow[] = $this->module->id . '.admin';
        }
        return array(
            array('allow', 'roles' => $allow),
            array('deny', 'users' => array('*')),
        );
    }

    public function init()
    {
        $this->pageTitle = Yii::app()->name;

        $bootstrap = Yii::createComponent(array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'coreCss' => true,
            'responsiveCss' => true,
            'plugins' => array(
                'alert',
                'button',
                'carousel',
                'collapse',
                'dropdown',
                'model',
                'popover',
                'tab',
                'typeahead',
                'transition' => false,
                'tooltip' => array(
                    'selector' => 'a.tooltip',
                    'options' => array(
                        'placement' => 'bottom',
                    ),
                ),
            ),
        ));
        Yii::app()->setComponent('bootstrap', $bootstrap);
    }

    public function render($view, $data=null, $return=false)
    {
        Yii::trace(CVarDumper::dumpAsString(Yii::app()->request), 'dev.trace.myTrace');
        if($this->beforeRender($view))
        {
            $output=$this->renderPartial($view,$data,true);
            if(($layoutFile=$this->getLayoutFile($this->layout))!==false) {
                $output=$this->renderFile($layoutFile,array('content'=>$output),true);
            }

            $output = $this->renderFile(dirname(__FILE__) . '/views/layouts/main.php', array('content' => $output), true);

            $this->afterRender($view,$output);

            $output=$this->processOutput($output);

            if ($return) {
                return $output;
            } else {
                echo $output;
            }
        }
    }

    /**
     * Ассеты
     */
    private $_assetsUrl;
    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null) {
            $this->_assetsUrl = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets');
        }

        return $this->_assetsUrl;
    }
}
