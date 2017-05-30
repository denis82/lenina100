
<div class="block-content">
    <div class="block-name">
        Вопрос-ответ
    </div>
	<div class="block-qa cf">
        <?php foreach($faqs as $f): ?>
        <div class="question cf">
            <i class="black small"> <?php echo $f->name_q; ?> спрашивает: </i>
            <a href="/reviews" class="quest"><?php echo $f->quest; ?></a>
			<?php 
				$data = $f;
				if ($data->expert->name) :
			?>
					<?php $fio = explode(' ', $data->expert->name);
						if (!empty($fio[1])) $fio[1] = mb_substr($fio[1], 0, 1, 'UTF-8');
						if (!empty($fio[2])) $fio[2] = mb_substr($fio[2], 0, 1, 'UTF-8');
						$data->expert->name = implode('.', $fio);
					?>
					<div class='answer_link'>
					<a class="expert_box" href="/expert_box/<?php echo $data->expert->id;?>" class="answ"><?php echo $data->expert->name; ?> отвечает </a> 
					</div>
				<?php else: ?>
					<a href="" class="answ"><?php echo $data->name_a; ?> отвечает </a> 
			<?php endif; ?>
            <div class="arrow"></div>
        </div>
        <?php endforeach; ?>
		
		<?php echo CHtml::link('Все отзывы', array('/reviews'), array('class'=>'all')); ?>
    </div>
</div>