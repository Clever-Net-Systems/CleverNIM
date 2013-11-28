<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"pv_\"]').hide();
		//alert($('#Tag_type_de_tag_id option:selected').val());
                $('.pv_' + $('#Tag_type_de_tag_id option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Tag_type_de_tag_id').change(showHideParams);
                showHideParams();
});
");

?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'tag-form',
	'type' => 'vertical',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($tag)); ?>


	<?php echo $form->labelEx($tag,'groupement_id'); ?>
	<?php echo $form->dropDownList($tag,"groupement_id", CHtml::listData($tag->groupementsOK(), "id", "_intname")); ?>		<?php echo $form->error($tag,'groupement_id'); ?>
	<p class="hint">Groupement de restriction</p>
	<?php echo $form->labelEx($tag, 'postes'); ?>
	<?php $user = User::model()->findByPk(Yii::app()->user->id); ?>
	<?php echo $form->listBox($tag, "postesIds", CHtml::listData($user->getPostesOK(), "id", "_intname"), array("multiple" => "multiple")); ?>
	<?php echo $form->error($tag, 'postes'); ?>
	<p class="hint">Les postes associés à ce tag</p>
	<?php echo $form->labelEx($tag,'type_de_tag_id'); ?>
	<?php echo $form->dropDownList($tag,"type_de_tag_id", CHtml::listData(Typetag::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($tag,'type_de_tag_id'); ?>
	<p class="hint">Le type de ce tag</p>

<?php foreach ($paramvalues as $pname => $pvalue) { ?>
	<div class="pv_none <?php echo "pv_" . $pvalue->parametre->type_de_tag->id . " "; ?>">
		<?php echo $form->labelEx($pvalue, $pvalue->parametre->_intname); ?>
		<?php echo $form->error($pvalue, "[$pname]valeur"); ?>
		<?php if ($pvalue->parametre->type == 2) { ?>
		<?php echo $form->dropDownList($pvalue,"[$pname]valeur", explode(',', $pvalue->parametre->possibles)); ?>
		<?php } elseif ($pvalue->parametre->type == 1) { ?>
		<?php echo $form->checkBox($pvalue,"[$pname]valeur"); ?>
		<?php } else { ?>
		<?php echo $form->textField($pvalue, "[$pname]valeur", array('size' => 60, 'maxlength' => 255)); ?>
		<?php } ?>
		<p class="hint"><?php echo $pvalue->parametre->description; ?></p>
	</div>
<?php } ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $tag->isNewRecord ? 'Créer' : 'Sauvegarder')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
<?php $this->endWidget(); ?>
