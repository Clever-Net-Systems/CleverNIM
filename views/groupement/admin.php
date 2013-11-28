<?php
$this->pageTitle = Yii::t('app', 'Gestion des groupements');
$this->breadcrumbs = array(
	Yii::t('app', 'Gestion des groupements'),
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'groupement-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $groupement->search(),
	'selectableRows' => 2,
	'filter' => $groupement,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href="/groupement/export"><img src="/images/csv-16.png" alt="CSV Icon"></a>'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'nom',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('groupement/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Groupement'),
			)               
		     ),
		array(
			'name' => 'searchfaits',
			'filter' => null,
	 		'type' => 'raw',
			'value' => '$data->getAllfaitss();'
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('groupement-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{del}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("groupement/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
				),
				'del' => array (
					'label' => Yii::t('app', '<i class="icon-trash"></i>'),
					'url' => 'Yii::app()->createUrl("groupement/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('class' => 'delete', 'data-original-title' => 'Suppression', 'title' => 'Suppression'),
				),
			),
		),
	),
)); ?>

<?php $groupementform = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'fait_groupement-form',
	'type' => 'inline',
	'action' => Yii::app()->createUrl('groupement/create'),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $groupementform->errorSummary(array($newgroupement)); ?>
	<?php echo $groupementform->textFieldRow($groupement, 'nom', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du groupement")); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
