<?php
$this->pageTitle = Yii::t('app', 'Manage File');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage File'),
);
?>

<script>
/*$(function() {
	$("#mergebutton").click(function() {
		window.location = "<?php echo CController::createUrl("file/merge"); ?>/" + $.fn.yiiGridView.getSelection('file-grid');
	});
});*/
</script>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'file-grid',
	'type' => 'striped bordered condensed',
	//'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css'),
	//'cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css',
	//'template' => "{items}\n{summary}\n{pager}",
	'dataProvider' => $file->search(),
	'selectableRows' => 2,
	'filter' => $file,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		'id',
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => '_intname',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('file/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'File'),
			)               
		     ),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'filename',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('file/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'File'),
			)               
		     ),
		'size',
		array(
			'name' => 'cdate',
			'value' => '$data->cdate',
			'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name' => CHtml::activeName($file, 'cdate'),
				'value' => $file->attributes['cdate'],
				'language' => 'fr',
				'options' => array('showAnim' => 'fold', 'dateFormat' => 'yy-mm-dd', 'changeYear' => 'true', 'changeMonth' => 'true', 'showOtherMonths' => 'true', 'selectOtherMonths' => 'true'),
				'defaultOptions' => array('constrainInput' => false),
			), true),
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('file-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{delete}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("file/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("file/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/delete.png',
				),
			),
		),
	),
)); ?>
