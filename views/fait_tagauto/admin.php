<?php
$this->pageTitle = Yii::t('app', 'Manage Fait TagAuto');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Fait TagAuto'),
);
?>

<script>
/*$(function() {
	$("#mergebutton").click(function() {
		window.location = "<?php echo CController::createUrl("fait_tagauto/merge"); ?>/" + $.fn.yiiGridView.getSelection('fait_tagauto-grid');
	});
});*/
</script>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'fait_tagauto-grid',
	'type' => 'striped bordered condensed',
	//'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css'),
	//'cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css',
	//'template' => "{items}\n{summary}\n{pager}",
	'dataProvider' => $fait_tagauto->search(),
	'selectableRows' => 2,
	'filter' => $fait_tagauto,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'fact',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('fait_tagauto/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Fait_tagauto'),
			)               
		     ),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'valeur',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('fait_tagauto/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Fait_tagauto'),
			)               
		     ),
		array(
			'name' => 'operateur',
			'filter' => Fait_tagauto::getOperateur_values(),
			'type' => 'raw',
			'value' => 'Fait_tagauto::getOperateur_values($data->operateur)'
		),
		array(
			'name' => 'tag_id',
			'filter' => Tagauto::filterData('faits'),
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->tag->_intname), array("tagauto/update", "id" => $data->tag_id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("tagauto/coda", array("id" => $data->tag_id))))'
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('fait_tagauto-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{delete}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("fait_tagauto/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("fait_tagauto/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/delete.png',
				),
			),
		),
	),
)); ?>
