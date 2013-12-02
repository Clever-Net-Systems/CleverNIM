<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#Fait_groupement_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Fait_groupement_hastype').change(showHideParams);
                showHideParams();
});
");

?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo $fait_groupement->isNewRecord ? 'Nouveau Fait_groupement' : $fait_groupement->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'fait_groupement-form',
	'enableAjaxValidation' => true,
)); ?>
<?php echo $form->errorSummary(array($fait_groupement)); ?>

	<div class="row">
		<?php echo $form->labelEx($fait_groupement, 'fact'); ?>
		<?php echo $form->textField($fait_groupement, 'fact', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($fait_groupement, 'fact'); ?>
		<p class="hint">Le fact Facter</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($fait_groupement, 'valeur'); ?>
		<?php echo $form->textField($fait_groupement, 'valeur', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($fait_groupement, 'valeur'); ?>
		<p class="hint">La valeur du fact</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($fait_groupement, 'operateur'); ?>
		<?php echo $form->dropDownList($fait_groupement,'operateur', Fait_groupement::getOperateur_values()); ?>
		<?php echo $form->error($fait_groupement, 'operateur'); ?>
		<p class="hint">Opérateur de comparaison</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($fait_groupement,'groupement_id'); ?>
		<?php echo $form->dropDownList($fait_groupement,"groupement_id", CHtml::listData(Groupement::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($fait_groupement,'groupement_id'); ?>
		<p class="hint">Le groupement auquel est rattaché ce fait</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($fait_groupement->isNewRecord ? 'Créer' : 'Sauvegarder'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

		<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
