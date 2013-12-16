<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#Typetag_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Typetag_hastype').change(showHideParams);
                showHideParams();
});
");

?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'typetag-form',
	'type' => 'horizontal',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($typetag)); ?>
	<?php echo $form->textFieldRow($typetag, 'nom', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du tag")); ?>
	<div class="control-group">
		<?php echo $form->labelEx($typetag, 'icone', array('class' => 'control-label required')); ?>
		<div class="controls">
		<?php $this->widget('application.widgets.jqueryFileTree.jqueryFileTree', array(
			'name' => 'icone',
			'form' => $form,
			'model' => $typetag,
			'class' => 'Typetag',
		));
		?>
		</div>
		<?php echo $form->error($typetag, 'icone'); ?>
	</div>
	<?php echo $form->textFieldRow($typetag, 'classe', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom de la classe Puppet à appliquer")); ?>
	<?php echo $form->textFieldRow($typetag, 'description', array('size' => 60, 'maxlength' => 255, 'hint' => "La description du type de tag")); ?>

	<?php echo $form->labelEx($typetag,'Paramètre'); ?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'param-grid',
	'type' => 'striped bordered condensed',
	'template' => "{items}",
	'dataProvider' => $tagparam->search(),
	'selectableRows' => 2,
	//'filter' => $tagparam,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'columns' => array(
		'nom',
		'description',
		array(
			'name' => 'type',
			'filter' => Tagparam::getType_values(),
			'type' => 'raw',
			'value' => 'Tagparam::getType_values($data->type)'
		),
		'possibles',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'buttons' => array(
				'delete' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("tagparam/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					//'imageUrl' => Yii::app()->request->baseUrl . '/images/delete.png',
				),
			),
		),
	),
)); ?>
	<p class="hint">Les paramètres de ce type de tag</p>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $typetag->isNewRecord ? 'Créer' : 'Sauvegarder')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
<?php $this->endWidget(); ?>

<?php $paramform = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'tagparam-form',
	'type' => 'horizontal',
	'action' => Yii::app()->createUrl('tagparam/create', array('prevUri' => Yii::app()->request->requestUri)),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $paramform->errorSummary(array($newtagparam)); ?>
	<?php echo $paramform->textFieldRow($newtagparam, 'nom', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du paramètre")); ?>
	<?php echo $paramform->textFieldRow($newtagparam, 'description', array('size' => 60, 'maxlength' => 255, 'hint' => "La description du paramètre")); ?>
	<?php echo $paramform->dropDownListRow($newtagparam, 'type', Tagparam::getType_values(), array('hint' => "Le type du paramètre")); ?>
	<?php echo $paramform->textAreaRow($newtagparam, 'possibles', array('rows' => 8, 'cols' => 70, 'hint' => "Les valeurs du paramètre dans le cas d'une liste")); ?>
	<?php echo $paramform->hiddenField($newtagparam, 'type_de_tag_id', array('value' => $newtagparam->type_de_tag_id)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
