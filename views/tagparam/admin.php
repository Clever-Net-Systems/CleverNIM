<?php
$this->pageTitle = Yii::t('app', 'Manage TagParam');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage TagParam'),
);
?>

<script>
/*$(function() {
	$("#mergebutton").click(function() {
		window.location = "<?php echo CController::createUrl("tagparam/merge"); ?>/" + $.fn.yiiGridView.getSelection('tagparam-grid');
	});
});*/
</script>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'tagparam-grid',
	'type' => 'striped bordered condensed',
	//'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css'),
	//'cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css',
	//'template' => "{items}\n{summary}\n{pager}",
	'dataProvider' => $tagparam->search(),
	'selectableRows' => 2,
	'filter' => $tagparam,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'nom',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('tagparam/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Tagparam'),
			)               
		     ),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'description',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('tagparam/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Tagparam'),
			)               
		     ),
		array(
			'name' => 'type',
			'filter' => Tagparam::getType_values(),
			'type' => 'raw',
			'value' => 'Tagparam::getType_values($data->type)'
		),
		'possibles',
		array(
			'name' => 'searchvaleurs',
			'filter' => null,
	 		'type' => 'raw',
			'value' => '$data->getAllvaleurss();'
		),
		array(
			'name' => 'type_de_tag_id',
			'filter' => Typetag::filterData('parametre'),
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->type_de_tag->_intname), array("typetag/update", "id" => $data->type_de_tag_id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("typetag/coda", array("id" => $data->type_de_tag_id))))'
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('tagparam-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{delete}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("tagparam/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("tagparam/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/delete.png',
				),
			),
		),
	),
)); ?>
