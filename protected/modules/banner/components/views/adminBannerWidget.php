<div class="tree">
    <ul>
        <?php foreach($items as $item): ?>
            <li>
                <?php echo CHtml::link($item->name, array("indexItems", "id"=>$item->id)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>