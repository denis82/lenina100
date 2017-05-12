<?php $this->beginContent('//layouts/main'); ?>
<div class="content cf">
	<div class="main">
		<h1><?php echo $this -> clips['content_title']; ?></h1>
		<?php echo $content; ?>
		<?php if ($_SERVER['REQUEST_URI'] != '/write') :?>
		<hr>
		<div class="row cf">
			<div class="span3">
				<a href="/write" class="faq button cboxForm red front"><center>Запишитесь <br /> на приём</center></a>
			</div>
		</div>
		<div class="row cf link_message">
			<div class="span3">
				<a href="/message" class="faq button cboxForm front"><center>Задайте вопрос <br /> специалисту</center></a>
			</div>
			<div class="span3 black">
				<div class="small bold">Запишитесь на приём к врачу:</div>
				<div class="phone-num"><span class="small">+7 (3412)</span> 68-32-08</div>
			</div>
		</div>
		<?php endif; ?>

		<?php 
			$prices = $this -> page -> price_content;
			if ($prices) :
		?>
		<div class="price">
			<a href="" class="ajax pfdintextcondpro">Цены на услуги</a>
			<?php echo $prices; ?>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="sidebar">
		<?php if ($this->page->right_content) :?>
			<div class="side-block shadow cf">
				<div class="side-content cf">
					<?php echo $this->page->right_content; ?>
				</div>
			</div>
		<?php endif;?>
		<?php if (strpos($_SERVER['REQUEST_URI'], 'services')) :?>
		
				<?php $this->widget('info.widgets.RecentInfoWidget'); ?>

		<?php endif;?>
		
		<?php if ($_SERVER['REQUEST_URI'] != '/write') :?>
		<hr class="mr_t_28">
		<div class="block-questions">
			<?php $this->widget('faq.components.WFaqLast'); ?>
		</div>
		<?php endif;?>
	</div>
	
</div>
<?php $this->endContent(); ?>