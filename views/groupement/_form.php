<?php
?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'groupement-form',
	'type' => 'vertical',
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
	'type' => 'inline',
	'action' => Yii::app()->createUrl('fait_groupement/create', array('prevUri' => Yii::app()->request->requestUri)),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $faitform->errorSummary(array($newfait)); ?>
	<?php echo $faitform->textFieldRow($newfait, 'fact', array('size' => 60, 'maxlength' => 255, 'hint' => "Le fact Facter")); ?>
	<?php echo $faitform->dropDownList($newfait, 'operateur', Fait_groupement::getOperateur_values()); ?>
	<?php echo $faitform->textFieldRow($newfait, 'valeur', array('size' => 60, 'maxlength' => 255, 'hint' => "La valeur du fact")); ?>
	<?php echo $faitform->hiddenField($newfait, 'groupement_id', array('value' => $newfait->groupement_id)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
