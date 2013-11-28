<?php
$this->pageTitle = Yii::t('app', 'Manage TypeTag');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage TypeTag'),
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'typetag-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $typetag->search(),
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'filter' => $typetag,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href="/typetag/export"><img src="/images/csv-16.png" alt="CSV Icon"></a>'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'name' => 'icone',
			'filter' => false,
			'type' => 'raw',
			'value' => 'CHtml::image($data->icone, $data->_intname, array("height" => 32))',
		),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'nom',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('typetag/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Typetag'),
			)
		     ),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'classe',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('typetag/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Typetag'),
			)               
		     ),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'description',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('typetag/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Typetag'),
			)               
		     ),
/*		array(
			'name' => 'searchtags',
			'filter' => null,
	 		'type' => 'raw',
			'value' => '$data->getAlltagss();'
		),*/
		array(
			'name' => 'searchparametre',
			'filter' => null,
	 		'type' => 'raw',
			'value' => '$data->getAllparametres();'
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('typetag-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{del}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("typetag/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', '<i class="icon-trash"></i>'),
					'url' => 'Yii::app()->createUrl("typetag/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('class' => 'delete', 'data-original-title' => 'Suppression', 'title' => 'Suppression'),
				),
			),
		),
	),
)); ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'typetag-form',
	'type' => 'vertical',
	'action' => Yii::app()->createUrl('typetag/create'),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($newtypetag)); ?>
	<?php echo $form->textFieldRow($newtypetag, 'nom', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du tag")); ?>
	<?php echo $form->labelEx($typetag, 'icone'); ?>
	<?php $this->widget('application.widgets.jqueryFileTree.jqueryFileTree', array(
		'name' => 'icone',
		'form' => $form,
		'model' => $typetag,
		'class' => 'Typetag',
	));
	?>
	<?php echo $form->error($typetag, 'icone'); ?>
	<?php echo $form->textFieldRow($newtypetag, 'classe', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom de la classe Puppet à appliquer")); ?>
	<?php echo $form->textFieldRow($newtypetag, 'description', array('size' => 60, 'maxlength' => 255, 'hint' => "La description du type de tag")); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
