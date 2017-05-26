<?php         
if(!empty($tree)):
	// комментарий
    $ulClass = !isset($level) ? '' : ($level == 2 ? 'submenu' : '');
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
				
					$this->render($view, array('tree'=>$node->childs, 'view'=>$view, 'level'=>$node->level));
				
				echo CHtml::link('<span>' . $node->label . '</span> <i class="icon icon-arrow"></i>', '#', array('class'=>'sub', 'data-toggle'=>'dropdown'));
            }else if($node->is_visible){
				if ($url != '/')
					if ($node->level == 2)
						echo CHtml::link('<span>'.$node->label.'</span>', $url);
					else 
						echo CHtml::link($node->label, $url);
				else
					echo CHtml::link("<i class='icon icon-home'></i>", $url, array('class'=>'home'));
            };
        echo CHtml::closeTag('li');
        if (isset($parent) && $node == $parent)
			echo CHtml::tag('li', array('class'=>'divider'));
    }
    echo CHtml::closeTag('ul');

endif; ?>