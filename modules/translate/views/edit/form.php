<?php
$this->pageTitle = Yii::t('app', 'New translation');
$this->breadcrumbs = array(
	Yii::t('app', 'Administration'),
	Yii::t('app', 'Internationalization'),
	Yii::t('app', 'New translation'),
);
?>

<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo Yii::t('app', 'New translation') . " - " . TranslateModule::translator()->acceptedLanguages[$model->language]; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'newtranslation-form',
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'id', array('size' => 10, 'maxlength' => 10)); ?>
	<?php echo $form->hiddenField($model, 'language', array('size' => 16, 'maxlength' => 16)); ?>

	<div class="row">
		<?php echo $form->labelEx($model->source, 'category'); ?>
		<?php echo $form->textField($model->source, 'category', array('disabled' => 'disabled')); ?>
		<?php echo $form->error($model->source, 'category'); ?>
		<p class="hint">The category of the message</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->source, 'message'); ?>
		<?php echo $form->textField($model->source, 'message', array('disabled' => 'disabled')); ?>
		<?php echo $form->error($model->source, 'message'); ?>
		<p class="hint">The message to be translated</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'translation'); ?>
		<?php echo $form->textArea($model, 'translation', array('rows' => 2, 'cols' => 80)); ?>
		<?php echo $form->error($model, 'translation'); ?>
		<p class="hint">The translation in <?php echo TranslateModule::translator()->acceptedLanguages[$model->language]; ?></p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(TranslateModule::t($model->getIsNewRecord() ? 'Create' : 'Update')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
		</div>
	</div>
</div>
