<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#Fait_tagauto_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Fait_tagauto_hastype').change(showHideParams);
                showHideParams();
});
");

?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo $fait_tagauto->isNewRecord ? 'Nouveau Fait_tagauto' : $fait_tagauto->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'fait_tagauto-form',
	'enableAjaxValidation' => true,
)); ?>
<?php echo $form->errorSummary(array($fait_tagauto)); ?>

	<div class="row">
		<?php echo $form->labelEx($fait_tagauto, 'fact'); ?>
		<?php echo $form->textField($fait_tagauto, 'fact', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($fait_tagauto, 'fact'); ?>
		<p class="hint">Le fact Facter</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($fait_tagauto, 'valeur'); ?>
		<?php echo $form->textField($fait_tagauto, 'valeur', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($fait_tagauto, 'valeur'); ?>
		<p class="hint">La valeur du fact</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($fait_tagauto, 'operateur'); ?>
		<?php echo $form->dropDownList($fait_tagauto,'operateur', Fait_tagauto::getOperateur_values()); ?>
		<?php echo $form->error($fait_tagauto, 'operateur'); ?>
		<p class="hint">Opérateur de comparaison</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($fait_tagauto,'tag_id'); ?>
		<?php echo $form->dropDownList($fait_tagauto,"tag_id", CHtml::listData(Tagauto::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($fait_tagauto,'tag_id'); ?>
		<p class="hint">Le tag auquel ce fait appartient</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($fait_tagauto->isNewRecord ? 'Créer' : 'Sauvegarder'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

		<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
