<div class="well">
    Добро пожаловать, <?php echo $user->name; ?>!<br />
    <?php echo CHtml::link('Личный кабинет', array('/users/default/update')); ?><br />
    <?php echo Chtml::link('Выход', array('/users/default/logout')); ?>
</div>
