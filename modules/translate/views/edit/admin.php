<?php
$this->pageTitle = Yii::t('app', 'All translations');
$this->breadcrumbs = array(
	Yii::t('app', 'Administration'),
	Yii::t('app', 'Internationalization'),
	Yii::t('app', 'All translations'),
);
?>

<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo Yii::t('app', "All translations"); ?></h2><?php echo CHtml::link("<span>Import</span>", CController::createUrl("societe/import"), array('class' => 'btn grey')); ?><?php echo CHtml::link("<span>Export</span>", CController::createUrl("societe/export"), array('class' => 'btn grey')); ?></div>
	<div class="widget_body">
		<div class="widget_content">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'translations-grid',
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/ezcss/ccgridview.css'),
	'cssFile' => Yii::app()->baseUrl . '/ezcss/ccgridview.css',
	'template' => "{items}\n{summary}\n{pager}",
	'dataProvider' => $model->search(),
	'filter' => $model,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
	'pager' => array('class' => 'CLinkPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >'), 'header' => Yii::t('app', 'Aller à la page:')),
	'columns' => array(
		'message',
		array(
			'name' => 'category',
			'filter' => CHtml::listData(MessageSource::model()->findAll(), 'category', 'category'),
			'type' => 'raw',
		),
		array(
			'name' => 'language',
			'filter' => CHtml::listData($model->findAll(new CDbCriteria(array('group' => 'language'))), 'language', 'language'),
			'type' => 'raw',
		),
		'translation',
		array(
			'class' => 'CButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('translations-grid', { data:{ pageSize: $(this).val() } });")
			),
			'template'=>'{update}{delete}',
			'updateButtonUrl' => 'Yii::app()->getController()->createUrl("update", array("id" => $data->id, "language" => $data->language))',
			'deleteButtonUrl' => 'Yii::app()->getController()->createUrl("delete", array("id" => $data->id, "language" => $data->language))',
		),
	),
)); ?>		</div>
	</div>
</div>
