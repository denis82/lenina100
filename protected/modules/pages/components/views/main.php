<?php if(!empty($tree)):

    $ulClass = !isset($level) ? 'nav pull-left' : ($level == 2 ? 'dropdown-menu' : '');
    echo CHtml::openTag('ul', array('class'=>$ulClass));
    if (isset($parent)) {
        $parent->childs = array();
        array_unshift($tree, $parent);
    }
    foreach($tree as $node) {
        $url = $node->url ? $node->url : $node->param;
        $activeClass = $this->isActive($url) ? 'active' : '';

        $liClass = !empty($node->childs) && $node->level > 1 ? 'dropdown ' . $activeClass : $activeClass;
        echo CHtml::openTag('li', array('class'=>$liClass));
            if(!empty($node->childs) && $node->level > 1){

                echo CHtml::link($node->label . '<b class="caret"></b>', '#', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'));
                $this->render($view, array('tree'=>$node->childs, 'view'=>$view, 'level'=>$node->level, 'parent'=> $node));

            }else if($node->is_visible){
                echo CHtml::link($node->label, $url);
            };
        echo CHtml::closeTag('li');
        if (isset($parent) && $node == $parent)
        echo CHtml::tag('li', array('class'=>'divider'));
    }
    echo CHtml::closeTag('ul');

endif; ?>
