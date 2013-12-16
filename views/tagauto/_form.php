<?php
?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'tagauto-form',
	'type' => 'horizontal',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($tagauto)); ?>
	<?php $user = User::model()->findByPk(Yii::app()->user->id); ?>
	<?php echo $form->dropDownListRow($tagauto,"groupement_id", CHtml::listData($user->groupements, "id", "_intname"), array('hint' => "Restriction group")); ?>
	<?php echo $form->textFieldRow($tagauto, 'nom', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du tag automatique")); ?>
	<?php echo $form->textFieldRow($tagauto, 'classe', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom de la classe Puppet à appliquer")); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'fait_tagauto-grid',
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
			'filter' => Fait_tagauto::getOperateur_values(),
			'type' => 'raw',
			'value' => 'Fait_tagauto::getOperateur_values($data->operateur)'
		),
		'valeur',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'buttons' => array(
				'delete' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("fait_tagauto/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
				),
			),
		),
	),
)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $tagauto->isNewRecord ? 'Créer' : 'Sauvegarder')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>

<?php $this->endWidget(); ?>

<?php $faitform = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'fait_tagauto-form',
	'type' => 'horizontal',
	'action' => Yii::app()->createUrl('fait_tagauto/create', array('prevUri' => Yii::app()->request->requestUri)),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $faitform->errorSummary(array($newfait)); ?>
	<?php echo $faitform->textFieldRow($newfait, 'fact', array('size' => 60, 'maxlength' => 255, 'hint' => "Le fact Facter")); ?>
	<?php echo $faitform->dropDownListRow($newfait, 'operateur', Fait_tagauto::getOperateur_values(), array('hint' => "The comparison operator")); ?>
	<?php echo $faitform->textFieldRow($newfait, 'valeur', array('size' => 60, 'maxlength' => 255, 'hint' => "La valeur du fact")); ?>
	<?php echo $faitform->hiddenField($newfait, 'tag_id', array('value' => $newfait->tag_id)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
