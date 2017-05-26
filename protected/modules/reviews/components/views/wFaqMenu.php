<?php
/**
 * Представление виджета, выводящего список разделов каталога.
 */
if (isset($_GET['category']))
    $s = $_GET['category'];
else
    $s = null;
?>

<div class="block-rubrik-top"></div>
<div class="block-rubrik">
    <h3>РУБРИКИ</h3>
    
    <ul>
        <?php foreach ($items as $item): ?>
        <?php if ($item->url == $s): ?>
            <li class="active"><?php echo CHtml::link($item->title, array('/faq/default/index', 'category' => $item->url)); ?></li>
        <?php else: ?>
            <li><?php echo CHtml::link($item->title, array('/faq/default/index', 'category' => $item->url)); ?></li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    
    <?php echo CHtml::link('ЗАДАТЬ ВОПРОС', array('/faq/default/ask'), array(
        'title' => 'Задать вопрос',
        'class' => 'button-question'
    )); ?>
</div>