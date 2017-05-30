<div class="main">
<?php if(!empty($_GET['tag'])): ?>
<h1>Materials Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>
<?php if(!empty($search->string)): ?>
<h1>Найдено по запросу <i><?php echo CHtml::encode($search->string); ?></i></h1>
<?php endif; ?>
<?php 
function highlight ($text, $word)
{
    $regexp =     '/(.)(.)+'.$word.'(.)+(.)/';
    $m = '';
    if (preg_match_all ($regexp, $text, $m))
    {
        return $m[0][0];
    } else {
	return '';
    }   
}
?>
<?php foreach($materials as $material): ?>
<?php
        $pizza = explode('>', $material->content);
        $s = '';
        for ($i = 0; $i < count($pizza); $i++) {
                $piece = explode('<', $pizza[$i]);
                $replace = preg_replace('/('.$search->string.')/i', '<b><span style="background:yellow;">${1}</span></b>', $piece[0]);
                if (count($piece) == 2) {
                        $s .= $replace.'<'.$piece[1].'>';
                } else if (count($piece) == 1) {
                        $s .= $replace;
                }
        }
        
        $material->content = highlight ($s, $search->string);
	
        $this->renderPartial('_view',array(
                'dataProvider'=>$material,
        ));
?>
<?php endforeach; ?>

<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
</div>