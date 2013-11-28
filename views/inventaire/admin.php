<?php
$this->pageTitle = Yii::t('app', 'Inventaire des machines');
$this->breadcrumbs = array(
	Yii::t('app', 'Inventaire des machines'),
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'inventaire-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $inventaire->search(),
//	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'selectableRows' => 2,
	'filter' => $inventaire,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href="/inventaire/export"><img src="/images/csv-16.png" alt="CSV Icon"></a>'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array_merge(array(
		array(
			'name' => 'host_id',
			'filter' => Poste::filterData('inventaires'),
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->host->_intname), array("host/update", "id" => $data->host_id), array("class" => "inventairelistitem", "rel" => "popover", "data-trigger" => "hover", "data-title" => "title", "data-content" => Yii::app()->createUrl("host/coda", array("id" => $data->host_id))))'
		),
	), Inventaire::getFactColumns(), array(
		array(
			'name' => 'software',
			'value' => '$data->software',
		),
		array(
			'name' => 'version',
			'value' => '$data->version',
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'addCol',
				'',
				array_merge(array('Afficher le fact :' => "Afficher le fact :"), Poste::getFactColumnsList()),
				array('onchange' => "$.fn.yiiGridView.update('inventaire-grid', { data:{ addCol: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;'))
				. CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('inventaire-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("inventaire/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', '<i class="icon-trash"></i>'),
					'url' => 'Yii::app()->createUrl("inventaire/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('class' => 'delete', 'data-original-title' => 'Suppression', 'title' => 'Suppression'),
				),
			),
		),
	)),
)); ?>
