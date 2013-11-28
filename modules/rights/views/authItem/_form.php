<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'role-form',
	'type' => 'vertical',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($model)); ?>
	<?php echo $form->textFieldRow($model, 'name', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du rôle")); ?>
	<?php echo $form->textFieldRow($model, 'description', array('size' => 60, 'maxlength' => 255, 'hint' => "La description du rôle")); ?>
	<?php if( Rights::module()->enableBizRule===true ): ?>
		<?php echo $form->textFieldRow($model, 'bizRule', array('size' => 60, 'maxlength' => 255, 'hint' => "Le code métier à exécuter lors de la validation de l'accès")); ?>
	<?php endif; ?>
	<?php if( Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData ): ?>
		<?php echo $form->textFieldRow($model, 'data', array('size' => 60, 'maxlength' => 255, 'hint' => "Données additionnelles disponibles lors de l'exécution du code métier")); ?>
	<?php endif; ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Sauvegarder')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel')); ?>
<?php $this->endWidget(); ?>
