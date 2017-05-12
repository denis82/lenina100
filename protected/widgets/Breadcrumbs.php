<?php

Yii::import('zii.widgets.CBreadcrumbs');

/**
 * Сделано по Bootstrap 2.0. Во всех остальных случаях используйте CBreadcrumbs 
 * из zii
 */
class Breadcrumbs extends CBreadcrumbs
{
    public function run()
    {
        if (empty($this->links)) {
            return;
        }

        $result = '';
        $result .= '<li>'.CHtml::link('Главная', '/').' <span class="divider">/</span></li>';
        $count = count($this->links);
        $i = 1;
        foreach ($this->links as $label => $url) {
            if (is_string($label) || is_array($url)) {
                $link = CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url);
            } else {
                $link = $this->encodeLabel ? CHtml::encode($url) : $url;
            }

            if ($i == $count) {
                $result .= CHtml::tag('li', array('class' => 'active'), $link);
            } else {
                $result .= CHtml::tag('li', array(), $link) . '<span class="divider">/</span>';
            }

            $i += 1;
        }

        echo CHtml::tag('ul', array('class' => 'breadcrumb'), $result);
    }
}
