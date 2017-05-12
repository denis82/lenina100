
    <?php foreach ($dataProvider->data as $category): ?>
    <?php if ($category->itemsCount > 0): ?>
        <div class="item_photo">
            <h2><a name="<?php echo $category->id; ?>"></a><?php echo $category->name; ?></h2>
            <?php $items = $category->items; ?>
                <ul>
                    <?php foreach ($items as $item): ?>
                    <li>
                        <?php
                        echo CHtml::link(CHtml::image($item->min_image_url,
                                            $item->image_description,
                                            array('width' => '120', 'height' => '101')),
                                    $item->full_image_url,
                                    array('title' => $item->image_description,
                                          'rel' => 'category-1' . $category->id,
                                          'class' => 'thickbox'));
                        ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php if ($category->itemsCount > 5): ?>
                    <a class="more" href="">Больше фото</a>
            <?php endif; ?>
        </div>


    <?php endif; ?>
    <?php endforeach; ?>
