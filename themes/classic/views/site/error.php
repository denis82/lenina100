<div class="main not-found cf">
	<?php if ($this -> pageTitle == 'Ошибка 404') :?>
	<img src="/themes/classic/assets/images/404.jpg" align="left">
	<div class="right">
		<h1><?php echo 'Страница не найдена';?></h1>
		<p><?php echo $message; ?></p>
	</div>
	<?php endif;?>
	<?php if ($this -> pageTitle != 'Ошибка 404') :?>
	<div class="right">
		<h1><?php echo $this -> pageTitle;?></h1>
		<p><?php echo $message; ?></p>
	</div>
	<?php endif;?>
</div>