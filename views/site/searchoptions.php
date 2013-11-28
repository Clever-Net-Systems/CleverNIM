<?php
$this->pageTitle = Yii::t('app', 'Search options');
$this->breadcrumbs = array(
	Yii::t('app', 'Search options'),
);
?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'searchoptions-form',
	'type' => 'horizontal',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

				<?php echo $form->labelEx($model,'defaultnblines'); ?>
				<?php echo $form->textField($model,'defaultnblines'); ?>
				<?php echo $form->error($model,'defaultnblines'); ?>
				<p class="hint">Default number of lines shown on the search results page</p>
				<?php echo CHtml::submitButton('Soumettre'); ?>
				<p></p>
				<p>Warning! The following operation can take a long time.</p>
				<?php echo CHtml::submitButton('Reindex search database'); ?>
<?php $this->endWidget(); ?>
