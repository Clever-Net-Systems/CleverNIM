<?php
$this->pageTitle='Options';
$this->breadcrumbs=array(
	'Options',
);

?>

    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Options de coût</h2>
	</div>
        <div class="widget_body">
<div class="wide form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'options-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<p class="note">Les champs avec <span class="required">*</span> sont requis.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'frais_port_fixe'); ?>
		<?php echo $form->textField($model,'frais_port_fixe', array('size' => 5, 'maxlength' => 5)); ?> €
		<?php echo $form->error($model,'frais_port_fixe'); ?>
		<p class="hint">Frais de port fixes par panier</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'frais_port_variable'); ?>
		<?php echo $form->textField($model,'frais_port_variable', array('size' => 5, 'maxlength' => 5)); ?> €
		<?php echo $form->error($model,'frais_port_variable'); ?>
		<p class="hint">Frais de port variables par commande, par cm2 de surface</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'frais_ligne_fixe'); ?>
		<?php echo $form->textField($model,'frais_ligne_fixe', array('size' => 5, 'maxlength' => 5)); ?> €
		<?php echo $form->error($model,'frais_ligne_fixe'); ?>
		<p class="hint">Coût fixe par ligne</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'frais_ligne_variable'); ?>
		<?php echo $form->textField($model,'frais_ligne_variable', array('size' => 5, 'maxlength' => 5)); ?> €
		<?php echo $form->error($model,'frais_ligne_variable'); ?>
		<p class="hint">Coût variable par cm de longueur, par ligne</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nb_max_lignes'); ?>
		<?php echo $form->textField($model,'nb_max_lignes', array('size' => 5, 'maxlength' => 5)); ?>
		<?php echo $form->error($model,'nb_max_lignes'); ?>
		<p class="hint">Nombre maximal de lignes possible</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Soumettre'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

	</div>
    </div>
