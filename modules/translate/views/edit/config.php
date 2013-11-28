<?php
$this->pageTitle = Yii::t('app', 'i18n Configuration');
$this->breadcrumbs = array(
	Yii::t('app', 'Administration'),
	Yii::t('app', 'Internationalization'),
	Yii::t('app', 'i18n Configuration'),
);
?>

<?php
$this->widget('application.widgets.eguiders.EGuider', array(
	'id'            => 'i18n',
	'title'         => 'i18n Configuration',
	'description'   => $this->renderPartial('application.ezviews.site.eguiders.i18n', null, true),
	'attachTo'      => '#ConfigForm_langselect',
	'position'      => 3,
	'overlay'       => false,
	'xButton'       => true,
	'show'          => true
)); ?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo Yii::t('app', 'i18n Configuration'); ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'config-form',
	'enableClientValidation' => true,
	'enableAjaxValidation' => true,
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'langselect'); ?>
		<?php echo $form->dropDownList($model,'langselect', array('Fixed' => 'Fixed', 'Browser' => 'Let the browser decide', 'User' => 'Let the user decide')); ?>
		<?php echo $form->error($model,'langselect'); ?>
		<p class="hint">Your application's language selection mode</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fixedlang'); ?>
		<?php echo $form->dropDownList($model,'fixedlang', TranslateModule::translator()->acceptedLanguages); ?>
		<?php echo $form->error($model,'fixedlang'); ?>
		<p class="hint">Your fixed /default language selection</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'authorizedlanguages'); ?>
		<?php echo $form->listBox($model,'authorizedlanguages', TranslateModule::translator()->acceptedLanguages, array('multiple' => 'multiple')); ?>
		<?php echo $form->error($model,'authorizedlanguages'); ?>
		<p class="hint">List of languages to choose from</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'enableinlinetranslations'); ?>
		<?php echo $form->checkBox($model,'enableinlinetranslations'); ?>
		<?php echo $form->error($model,'enableinlinetranslations'); ?>
		<p class="hint">Whether to enable inline translations when logged in with Application Administrator role</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save options'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
		</div>
	</div>
</div>

