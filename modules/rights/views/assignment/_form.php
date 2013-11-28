<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'newperm-form',
	'type' => 'inline',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
	<?php echo $form->error($model, 'itemname'); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Assigner')); ?>
<?php $this->endWidget(); ?>
