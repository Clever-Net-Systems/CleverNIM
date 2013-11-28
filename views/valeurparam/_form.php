<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#Valeurparam_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Valeurparam_hastype').change(showHideParams);
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
	<div class="widget_title clearfix"><h2><?php echo $valeurparam->isNewRecord ? 'Nouveau Valeurparam' : $valeurparam->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'valeurparam-form',
	'enableAjaxValidation' => true,
)); ?>
<?php echo $form->errorSummary(array($valeurparam)); ?>

	<div class="row">
		<?php echo $form->labelEx($valeurparam, 'valeur'); ?>
		<?php echo $form->textField($valeurparam, 'valeur', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($valeurparam, 'valeur'); ?>
		<p class="hint">La valeur du paramètre du tag</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($valeurparam,'tag_id'); ?>
		<?php echo $form->dropDownList($valeurparam,"tag_id", CHtml::listData(Tag::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($valeurparam,'tag_id'); ?>
		<p class="hint">Le tag auquel cette valeur de paramètre appartient</p>
	</div>
	<div class="row">
		<?php echo $form->labelEx($valeurparam,'parametre_id'); ?>
		<?php echo $form->dropDownList($valeurparam,"parametre_id", CHtml::listData(Tagparam::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($valeurparam,'parametre_id'); ?>
		<p class="hint">Le parametre de tag pour cette valeur</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($valeurparam->isNewRecord ? 'Créer' : 'Sauvegarder'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

		<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
