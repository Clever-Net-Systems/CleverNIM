<?php
?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'poste-form',
	'type' => 'horizontal',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($poste)); ?>
	<?php echo $form->textFieldRow($poste, 'hostname', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom d'hôte du poste")); ?>
	<?php echo $form->textFieldRow($poste, 'nom_puppet', array('size' => 60, 'maxlength' => 255, 'hint' => "Nom Puppet avec la date de création", 'disabled' => 'disabled')); ?>
	<?php echo $form->textFieldRow($poste, 'numero_de_serie', array('size' => 60, 'maxlength' => 255, 'hint' => "Numéro de série inscrit sur le matériel")); ?>
	<?php echo $form->textFieldRow($poste, 'routeur', array('size' => 60, 'maxlength' => 255, 'hint' => "Numéro de série inscrit sur le matériel")); ?>
	<?php echo $form->textFieldRow($poste, 'creation', array('size' => 60, 'maxlength' => 255, 'hint' => "Date de création", 'disabled' => 'disabled')); ?>
	<?php echo $form->textFieldRow($poste, 'contact', array('size' => 60, 'maxlength' => 255, 'hint' => "Date du dernier contact", 'disabled' => 'disabled')); ?>

	<?php echo $form->labelEx($poste,'Tags'); ?>
	<?php echo $poste->getAlltagss(); ?>
	<p class="hint">Les tags attribués à ce poste</p>

	<?php echo $form->labelEx($poste,'Facts'); ?>
	<?php $factsprovider = new CArrayDataProvider($poste->getFacts(), array('keyField' => 'name'));
	$this->widget('bootstrap.widgets.TbGridView', array(
		'id' => 'facts-grid',
		'type' => 'striped bordered condensed',
		'dataProvider' => $factsprovider,
		'emptyText' => Yii::t('app', 'Pas de résultats'),
		'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
		'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
		'columns' => array(
			'name',
			'value',
		),
	)); ?>
	<p class="hint">Les facts Puppet de ce poste</p>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $poste->isNewRecord ? 'Créer' : 'Sauvegarder')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
<?php $this->endWidget(); ?>
