<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#Fait_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Fait_hastype').change(showHideParams);
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
	<div class="widget_title clearfix"><h2><?php echo $fait->isNewRecord ? 'Nouveau Fait' : $fait->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'fait-form',
	'enableAjaxValidation' => true,
)); ?>
<?php echo $form->errorSummary(array($fait)); ?>

	<div class="row">
		<?php echo $form->labelEx($fait, 'fact'); ?>
		<?php echo $form->dropDownList($fait,'fact', Fait::getFact_values()); ?>
		<?php echo $form->error($fait, 'fact'); ?>
		<p class="hint">La variable Facter</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($fait, 'valeur'); ?>
		<?php echo $form->textField($fait, 'valeur', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($fait, 'valeur'); ?>
		<p class="hint">La valeur du fact</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($fait, 'operateur'); ?>
		<?php echo $form->dropDownList($fait,'operateur', Fait::getOperateur_values()); ?>
		<?php echo $form->error($fait, 'operateur'); ?>
		<p class="hint">L'operateur de comparaison</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($fait,'selection_id'); ?>
		<?php echo $form->dropDownList($fait,"selection_id", CHtml::listData(Selection::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($fait,'selection_id'); ?>
		<p class="hint">La sélection utilisant ce fait</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($fait->isNewRecord ? 'Créer' : 'Sauvegarder'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

		<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
