<div class="tree">
    <h2>Категории вопросов</h2>
    <ul>
        <li><?php echo CHtml::link('Новые отзывы', array('index')); ?></li>
        <?php foreach($categories as $category): ?>
            <li>
                <?php echo CHtml::link($category->title, array('index','catId'=>$category->id)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <br />
    <ul>
        <li><?php echo CHtml::link('Редактировать категории', array('category')); ?></li>
    </ul>
</div>

