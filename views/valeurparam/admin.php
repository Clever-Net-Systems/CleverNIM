<?php
$this->pageTitle = Yii::t('app', 'Manage ValeurParam');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage ValeurParam'),
);
?>

<script>
$(function() {
	$("#mergebutton").click(function() {
		window.location = "<?php echo CController::createUrl("valeurparam/merge"); ?>/" + $.fn.yiiGridView.getSelection('valeurparam-grid');
	});
});
</script>

<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>ValeurParam</h2><?php echo CHtml::link("<span>Nouveau</span>", CController::createUrl("valeurparam/create"), array('class' => 'btn grey')); ?><?php echo CHtml::link("<span>Import</span>", CController::createUrl("/ezimporter/"), array('class' => 'btn grey')); ?><?php echo CHtml::link("<span>Export</span>", CController::createUrl("/ezimporter/import/export"), array('class' => 'btn grey')); ?><?php echo CHtml::link("<span>Merge</span>", '#', array('class' => 'btn grey', 'id' => 'mergebutton')); ?></div>
	<div class="widget_body">
		<div class="widget_content">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'valeurparam-grid',
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css',
	'template' => "{items}\n{summary}\n{pager}",
	'dataProvider' => $valeurparam->search(),
	'selectableRows' => 2,
	'filter' => $valeurparam,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
	'pager' => array('class' => 'CLinkPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >'), 'header' => Yii::t('app', 'Aller à la page:')),
	'columns' => array(
		array(
			'name' => 'tag_id',
			'filter' => null,
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->tag->_intname), array("tag/update", "id" => $data->tag_id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("tag/coda", array("id" => $data->tag_id))))'
		),
		array(
			'name' => 'parametre_id',
			'filter' => Tagparam::filterData('valeurs'),
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->parametre->_intname), array("tagparam/update", "id" => $data->parametre_id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("tagparam/coda", array("id" => $data->parametre_id))))'
		),
		'valeur',
		array(
			'class' => 'CButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('valeurparam-grid', { data:{ pageSize: $(this).val() } });")
			),
			'template' => '{update}{del}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("valeurparam/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("valeurparam/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/delete.png',
				),
			),
		),
	),
)); ?>		</div>
	</div>
</div>
