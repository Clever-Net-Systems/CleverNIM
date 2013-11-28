<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#Selection_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Selection_hastype').change(showHideParams);
                showHideParams();
});
");

$this->widget('application.widgets.eguiders.EGuider', array(
	'id'            => 'required_fields',
	'title'         => 'Required fields',
	'description'   => $this->renderPartial('application.views.site.eguiders.required_fields', null, true),
	'attachTo'      => 'label.required',
	'position'      => 3,
	'overlay'       => false,
	'xButton'       => true,
	'show'          => false
));
?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo $selection->isNewRecord ? 'Nouveau Selection' : $selection->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'selection-form',
	'enableAjaxValidation' => true,
)); ?>
<?php echo $form->errorSummary(array($selection)); ?>

	<div class="row">
		<?php echo $form->labelEx($selection, 'operateur'); ?>
		<?php echo $form->dropDownList($selection,'operateur', Selection::getOperateur_values()); ?>
		<?php echo $form->error($selection, 'operateur'); ?>
		<p class="hint">La relation logique entre les faits</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($selection, 'description'); ?>
		<?php echo $form->textField($selection, 'description', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($selection, 'description'); ?>
		<p class="hint">La description de la sélection</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($selection,'Faits'); ?>
		<?php echo $selection->getAllfaitss(); ?>		<p class="hint">Liste des faits déterminant la sélection</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($selection->isNewRecord ? 'Créer' : 'Sauvegarder'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

		<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
