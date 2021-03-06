<?php
/**
 * BHtml class file
 *
 * @author Tudor Sandu <exromany@gmail.com>
 */
class BHtml extends CHtml
{

    const TYPE_ERROR = 'error';
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';

    public static $defaultType = self::TYPE_INFO;
    
    public static function actions($options)
    {
        echo CHtml::openTag('div', array('class'=>'form-actions'));
        if (isset($options['submit']))
            echo CHtml::tag('button', array(
                'class' => isset($options['submitClass']) ? $options['submitClass'] : 'btn btn-info',
                'type' => 'submit',
            ), $options['submit']);
        if (isset($options['reset']))
            echo CHtml::tag('button', array(
                'class' => isset($options['resetClass']) ? $options['resetClass'] : 'btn',
                'type' => 'reset',
            ), $options['reset']);
        if (isset($options['buttons']))
            foreach ($options['buttons'] as $button) {
                if (!isset($button['options'])) $button['options'] = array(
                    'class' => 'btn',
                );
                if (!isset($button['url'])) $button['url'] = array('index');
                if (!isset($button['title'])) $button['title'] = 'Отмена';
                echo CHtml::link($button['title'], $button['url'], $button['options']);
            }
        echo CHtml::closeTag('div');
    }

    /*
     * Return an icon such as <i class="icon"></i>
     * @param string $icon - name of icon image
     */
    public static function icon($icon = null)
    {
        $icon = preg_split('/[\s,]+/', $icon);
        $class = '';
        foreach($icon as $i)
            $class .= ' icon' . (empty($i) ? '' : '-'.$i);
        return CHtml::tag('i',array('class'=>$class),'');
    }

    /*
     * Display all flash messages
     */
    public static function flash()
    {
        $flashes = Yii::app()->user->getFlashes();
        foreach ($flashes as $key => $message) {
            $type = self::$defaultType;
            if (is_array($message) && isset($message['message'])) {
                if (isset($message['type'])) $type = $message['type'];
                $message = $message['message'];
            } else {
                $type = $key;
            }

            switch ($type) {
                case 'error':
                    $class = 'alert-error';
                    break;
                case 'success':
                    $class = 'alert-success';
                    break;
                //case 'info':
                default:
                    $class = 'alert-info';
                    break;
            }

            echo '<div class="alert '.$class.'">'.$message.'</div>';
        }
    }
}