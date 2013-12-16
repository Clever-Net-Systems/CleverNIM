<?php
$this->pageTitle = Yii::t('app', 'Logs');
$this->breadcrumbs=array(
	Yii::t('app', 'Visualisation des logs'),
);
?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'audit-trail-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).') .
			CHtml::dropDownList('pageSize', Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange'=>"$.fn.yiiGridView.update('audit-trail-grid',{ data:{pageSize: $(this).val() }});")),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'name' => 'stamp',
			'value' => '$data->stamp',
			'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name' => CHtml::activeName($model, 'stamp'),
				'value' => $model->attributes['stamp'],
				'language' => 'fr',
				'options' => array('showAnim' => 'fold', 'dateFormat' => 'yy-mm-dd', 'changeYear' => 'true', 'changeMonth' => 'true', 'showOtherMonths' => 'true', 'selectOtherMonths' => 'true'),
				'defaultOptions' => array('constrainInput' => false),
			), true),
		),
		array(
			'name' => 'user_id',
			'filter' => CHtml::listData(User::model()->findAll(array('order' => 'username')), 'id', 'username'),
			'type' => 'raw',
			'value' => '$data->user ? CHtml::encode($data->user->username) : Yii::t("app", "Visitor")'
		),
		array(
			'name' => 'action',
			'filter' => CHtml::listData($model->actions, 'action', 'action'),
			'type' => 'raw',
			'value' => 'CHtml::encode($data->action)'
		),
		array(
			'name' => 'class',
			'filter' => CHtml::listData($model->classes, 'class', 'class'),
			'type' => 'raw',
			'value' => 'CHtml::encode($data->class)'
		),
		//'class_id',
		//'field',
		//'_intname',
		array(
			'name' => 'description',
			'filter' => '',
			'type' => 'raw',
			'value' => '$data->description',
		),
		//'old_value',
		//'new_value',
	),
)); ?>
        </div>
    </div>
