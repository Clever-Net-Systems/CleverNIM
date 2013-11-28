<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-form',
	'type' => 'vertical',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($model)); ?>
	<?php echo $form->textFieldRow($model, 'username', array('size' => 20, 'maxlength' => 20, 'hint' => "L'identifiant de l'utilisateur")); ?>
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo CHtml::activePasswordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($model,'password'); ?>
	<?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 128, 'hint' => "Email de l'utilisateur")); ?>
	<?php echo $form->labelEx($model, 'groupements'); ?>
	<?php echo $form->listBox($model, "groupementsIds", CHtml::listData(Groupement::model()->findAll(), "id", "_intname"), array("multiple" => "multiple")); ?>
	<?php echo $form->error($model, 'groupements'); ?>
	<p class="hint">Les groupements que ce profil peut administrer</p>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Créer' : 'Sauvegarder')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
<?php $this->endWidget(); ?>
