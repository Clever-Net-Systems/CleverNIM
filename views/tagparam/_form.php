<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#Tagparam_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Tagparam_hastype').change(showHideParams);
                showHideParams();
});
");

?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo $tagparam->isNewRecord ? 'Nouveau Tagparam' : $tagparam->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'tagparam-form',
	'enableAjaxValidation' => true,
)); ?>
<?php echo $form->errorSummary(array($tagparam)); ?>

	<div class="row">
		<?php echo $form->labelEx($tagparam, 'nom'); ?>
		<?php echo $form->textField($tagparam, 'nom', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($tagparam, 'nom'); ?>
		<p class="hint">Le nom du paramètre du tag</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($tagparam, 'description'); ?>
		<?php echo $form->textField($tagparam, 'description', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($tagparam, 'description'); ?>
		<p class="hint">La description du paramètre du tag</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($tagparam, 'type'); ?>
		<?php echo $form->dropDownList($tagparam,'type', Tagparam::getType_values()); ?>
		<?php echo $form->error($tagparam, 'type'); ?>
		<p class="hint">Le type du paramètre de tag</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($tagparam, 'possibles'); ?>
		<?php echo $form->textArea($tagparam, 'possibles', array('rows' => 8, 'cols' => 70)); ?>
		<?php echo $form->error($tagparam, 'possibles'); ?>
		<p class="hint">Valeurs séparées par une virgule dans le cas d'une liste</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($tagparam,'Valeurs'); ?>
		<?php echo $tagparam->getAllvaleurss(); ?>		<p class="hint">Les valeurs de ce parametre de tag</p>
	</div>
	<div class="row">
		<?php echo $form->labelEx($tagparam,'type_de_tag_id'); ?>
		<?php echo $form->dropDownList($tagparam,"type_de_tag_id", CHtml::listData(Typetag::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($tagparam,'type_de_tag_id'); ?>
		<p class="hint">Le type de tag auquel appartient ce paramètre</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($tagparam->isNewRecord ? 'Créer' : 'Sauvegarder'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

		<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
