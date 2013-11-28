<?php
$this->pageTitle = Yii::t('app', 'Manage Profil');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Profil'),
);
?>

<script>
/*$(function() {
	$("#mergebutton").click(function() {
		window.location = "<?php echo CController::createUrl("profil/merge"); ?>/" + $.fn.yiiGridView.getSelection('profil-grid');
	});
});*/
</script>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'profil-grid',
	'type' => 'striped bordered condensed',
	//'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css'),
	//'cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css',
	//'template' => "{items}\n{summary}\n{pager}",
	'dataProvider' => $profil->search(),
	'selectableRows' => 2,
	'filter' => $profil,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'name' => 'searchecoles',
			'filter' => Ecole::filterData('profils'),
			'type' => 'raw',
			'value' => '$data->getAllecoless()'
		),
		array(
			'name' => 'searchgroupements',
			'filter' => Groupement::filterData('profils'),
			'type' => 'raw',
			'value' => '$data->getAllgroupementss()'
		),
		array(
			'name' => 'profileuser_id',
			'filter' => "",
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->profileuser->_intname), array("user/update", "id" => $data->profileuser_id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("user/coda", array("id" => $data->profileuser_id))))'
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('profil-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{delete}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("profil/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', 'Suppression'),
					'url' => 'Yii::app()->createUrl("profil/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/delete.png',
				),
			),
		),
	),
)); ?>
