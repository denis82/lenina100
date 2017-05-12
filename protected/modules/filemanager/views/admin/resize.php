<script type="text/javascript">
    if(!$("input#ImageModel_isLink").is(":checked")) {
            $(".row.link").hide();
        }
        $("input#ImageModel_isLink").bind("click", function(){
            if($("input#ImageModel_isLink").is(":checked")) {
                $(".row.link").show();
            } else {
                $(".row.link").hide();
            }
        });
</script>
<div class="form">
<?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::activeHiddenField($model, 'path',array('value'=>$_GET['path'])); ?>
    <?php echo CHtml::errorSummary($model); ?>
    <div class="row">
        <?php echo CHtml::activeLabel($model, 'width'); ?>
        <?php echo CHtml::activeTextField($model, 'width', array('value'=>isset($image)?$image->width:$model->width)); ?>
    </div>
    <div class="row">
        <?php echo CHtml::activeLabel($model, 'height'); ?>
        <?php echo CHtml::activeTextField($model, 'height', array('value'=>isset($image)?$image->height:$model->height)); ?>
    </div>
    <?php if(empty($_GET['CKEditorFuncNum'])): ?>
        <div class="row">
            <?php echo CHtml::activeLabel($model, 'class'); ?>
            <?php echo CHtml::activeTextField($model, 'class'); ?>
        </div>
        <div class="row">
            <?php echo CHtml::activeLabel($model, 'alt'); ?>
            <?php echo CHtml::activeTextField($model, 'alt'); ?>
        </div>
        <div class="row link">
            <?php echo CHtml::activeLabel($model, 'title'); ?>
            <?php echo CHtml::activeTextField($model, 'title'); ?>
        </div>
        <div class="row">
            <?php echo CHtml::activeLabel($model, 'isLink'); ?>
            <?php echo CHtml::activeCheckBox($model, 'isLink'); ?>
        </div>
    <?php endif; ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton("Вставить"); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>