<?php foreach($items as $item): ?>
    <?php $class = $item->active ? 'active ' : ''; ?>
    <?php $class .= $item['children'] ? 'parent ' : ''; ?>
    <li class="<?php echo $class; ?>">
        <a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
        <?php if($item['children']): ?>
        <ul><?php $this->render('catalogMenu', array('items'=>$item['children'])); ?></ul>
        <?php endif; ?>
    </li>     
<?php endforeach; ?>