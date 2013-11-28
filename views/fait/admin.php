<?php
$this->pageTitle = Yii::t('app', 'Manage Fait');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Fait'),
);
?>

<script>
/*$(function() {
	$("#mergebutton").click(function() {
		window.location = "<?php echo CController::createUrl("fait/merge"); ?>/" + $.fn.yiiGridView.getSelection('fait-grid');
	});
});*/
</script>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'fait-grid',
	'type' => 'striped bordered condensed',
	//'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css'),
	//'cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css',
	//'template' => "{items}\n{summary}\n{pager}",
	'dataProvider' => $fait->search(),
	'selectableRows' => 2,
	'filter' => $fait,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'name' => 'fact',
			'filter' => Fait::getFact_values(),
			'type' => 'raw',
			'value' => 'Fait::getFact_values($data->fact)'
		),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'valeur',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('fait/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Fait'),
			)               
		     ),
		array(
			'name' => 'operateur',
			'filter' => Fait::getOperateur_values(),
			'type' => 'raw',
			'value' => 'Fait::getOperateur_values($data->operateur)'
		),
		array(
			'name' => 'selection_id',
			'filter' => Selection::filterData('faits'),
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->selection->_intname), array("selection/update", "id" => $data->selection_id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("selection/coda", array("id" => $data->selection_id))))'
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('fait-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{delete}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("fait/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("fait/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/delete.png',
				),
			),
		),
	),
)); ?>
