<div class="item">
    <h3>Пользователь <?php echo $data->id; ?></h3>

    <?php /*
    <?php echo CHtml::beginForm(array('/users/admin/update', 'id'=>$data->id), 'post', array('class'=>'userForm')); ?>

        <fieldset>
            <legend>Общая информация</legend>
            <div class="clearfix">
                <?php echo CHtml::activeLabelEx($data, 'name'); ?>
                <div class="input">
                    <?php echo CHtml::activeTextField($data, 'name'); ?>
                </div>
            </div>

            <div class="clearfix">
                <?php echo CHtml::activeLabelEx($data, 'email'); ?>
                <div class="input">
                    <?php echo CHtml::activeTextField($data, 'email'); ?>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Скидки</legend>
            <div class="clearfix">
            </div>
        </fieldset>

        <div class="actions">
            <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn primary')); ?>
        </div>
    <?php echo CHtml::endForm(); ?>
     */ ?>

    <?php $this->renderPartial('_form', array('model'=>$data)); ?>

    <strong>Дата регистрации:</strong> <?php echo date('j.n.Y', $data->create_time); ?><br />
</div>
