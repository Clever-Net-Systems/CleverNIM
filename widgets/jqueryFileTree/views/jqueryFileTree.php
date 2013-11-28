<div class="filetreeblock">
<div id="filetree_<?php echo $name; ?>" class="ftwidget"></div>
<?php echo $form->hiddenField($model, $name, array('size' => 60, 'maxlength' => 255)); ?>
<?php echo CHtml::image('', '', array('id' => $name . "_tmb", 'class' => 'ftthumbnail')); ?>
</div>
