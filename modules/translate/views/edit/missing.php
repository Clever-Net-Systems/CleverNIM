<?php
$this->pageTitle = Yii::t('app', 'Missing translations');
$this->breadcrumbs = array(
	Yii::t('app', 'Administration'),
	Yii::t('app', 'Internationalization'),
	Yii::t('app', 'Missing translations'),
);
?>

<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo "Missing translations" . " - " . TranslateModule::translator()->acceptedLanguages[Yii::app()->getLanguage()]; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'message-grid',
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/ezcss/ccgridview.css'),
	'cssFile' => Yii::app()->baseUrl . '/ezcss/ccgridview.css',
	'template' => "{items}\n{summary}\n{pager}",
	'dataProvider' => $model->search(),
	'filter' => $model,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),
	'pager' => array('class' => 'CLinkPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >'), 'header' => Yii::t('app', 'Aller à la page:')),
	'columns' => array(
		array(
			'name' => 'category',
			'filter' => CHtml::listData(MessageSource::model()->findAll(), 'category', 'category'),
			'type' => 'raw',
		),
		'message',
		array(
			'class' => 'CButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('message-grid', { data:{ pageSize: $(this).val() } });")
			),
			'template' => '{update}{delete}',
			'deleteButtonUrl'=>'Yii::app()->getController()->createUrl("missingdelete",array("id"=>$data->id))',
			'buttons' => array(
				'update' => array (
					'label' => TranslateModule::t('Create'),
					'url' => 'Yii::app()->getController()->createUrl("create", array("id" => $data->id, "language" => Yii::app()->getLanguage()))',
					'imageUrl' => Yii::app()->request->baseUrl . '/ezimages/update.png',
				),
			),
		),
	),
)); ?>		</div>
	</div>
</div>
