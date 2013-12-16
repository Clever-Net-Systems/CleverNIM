<?php
?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'groupement-form',
	'type' => 'horizontal',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($groupement)); ?>
	<?php echo $form->textFieldRow($groupement, 'nom', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du groupement")); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'fait_groupement-grid',
	'type' => 'striped bordered condensed',
	'template' => "{items}",
	'dataProvider' => $fait->search(),
	'selectableRows' => 2,
	//'filter' => $fait,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'columns' => array(
		'fact',
		array(
			'name' => 'operateur',
			'filter' => Fait_groupement::getOperateur_values(),
			'type' => 'raw',
			'value' => 'Fait_groupement::getOperateur_values($data->operateur)'
		),
		'valeur',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'buttons' => array(
				'delete' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("fait_groupement/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					//'imageUrl' => Yii::app()->request->baseUrl . '/images/delete.png',
				),
			),
		),
	),
)); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $groupement->isNewRecord ? 'Créer' : 'Sauvegarder')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
<?php $this->endWidget(); ?>

<?php $faitform = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'fait_groupement-form',
	'type' => 'horizontal',
	'action' => Yii::app()->createUrl('fait_groupement/create', array('prevUri' => Yii::app()->request->requestUri)),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $faitform->errorSummary(array($newfait)); ?>
	<?php echo $faitform->textFieldRow($newfait, 'fact', array('size' => 60, 'maxlength' => 255, 'hint' => "The name of the Facter fact")); ?>
	<?php echo $faitform->dropDownListRow($newfait, 'operateur', Fait_groupement::getOperateur_values(), array('hint' => "The operator to compare the fact and the value")); ?>
	<?php echo $faitform->textFieldRow($newfait, 'valeur', array('size' => 60, 'maxlength' => 255, 'hint' => "The value of the fact (specify a comma-separated list of values when using the IN operator)")); ?>
	<?php echo $faitform->hiddenField($newfait, 'groupement_id', array('value' => $newfait->groupement_id)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
