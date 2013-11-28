<?php
$this->pageTitle = Yii::t('app', 'Manage Poste');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Poste'),
);
?>

<?php $controller = $this; $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'poste-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $poste->search(),
	'selectableRows' => 2,
	'filter' => $poste,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href="/poste/export"><img src="/images/csv.png" alt="CSV Icon"></a>'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array_merge(array(
		array(
			'name' => 'searchtype',
			'filter' => array('Inconnus' => 'Inconnus'),
			'type' => 'raw',
			'value' => 'CHtml::image("/images/" . $data->getOSIcon())',
		),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'hostname',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('poste/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Poste'),
			)               
		     ),
		array(
			'name' => 'routeur',
			'value' => '$data->routeur ? $data->routeur : "En attente de l\'information"',
		),
		array(
			'name' => 'nom_puppet',
			'value' => '$data->nom_puppet ? $data->nom_puppet : "En attente de l\'information"',
		),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'numero_de_serie',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('poste/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Poste'),
			)               
		     ),
		array(
			'name' => 'creation',
			'value' => '$data->creation',
			'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name' => CHtml::activeName($poste, 'creation'),
				'value' => $poste->attributes['creation'],
				'language' => 'fr',
				'options' => array('showAnim' => 'fold', 'dateFormat' => 'yy-mm-dd', 'changeYear' => 'true', 'changeMonth' => 'true', 'showOtherMonths' => 'true', 'selectOtherMonths' => 'true'),
				'defaultOptions' => array('constrainInput' => false),
			), true),
		),
		array(
			'name' => 'contact',
			'value' => '$data->contact ? $data->contact : "Jamais connecté"',
			'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name' => CHtml::activeName($poste, 'contact'),
				'value' => $poste->attributes['contact'],
				'language' => 'fr',
				'options' => array('showAnim' => 'fold', 'dateFormat' => 'yy-mm-dd', 'changeYear' => 'true', 'changeMonth' => 'true', 'showOtherMonths' => 'true', 'selectOtherMonths' => 'true'),
				'defaultOptions' => array('constrainInput' => false),
			), true),
		),
	), Poste::getFactColumns(), array(
		array(
			'name' => 'searchtags',
			'filter' => null,
	 		'type' => 'raw',
			'value' => function($data, $row) use ($controller) { return $controller->renderPartial('taglist', array('poste' => $data), true); }
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'addCol',
				'',
				array_merge(array('Afficher le fact :' => "Afficher le fact :"), Poste::getFactColumnsList()),
				array('onchange' => "$.fn.yiiGridView.update('poste-grid', { data:{ addCol: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;'))
				. CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('poste-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{vnc}{kick}{update}{del}',
			'buttons' => array(
				'vnc' => array (
					'label' => Yii::t('app', '<i class="icon-eye-open"></i>'),
					'url' => 'Yii::app()->createUrl("poste/vnc", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('data-original-title' => 'VNC', 'title' => 'VNC'),
				),
				'kick' => array (
					'label' => Yii::t('app', '<i class="icon-bookmark"></i>'),
					'url' => 'Yii::app()->createUrl("poste/kick", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('data-original-title' => 'Set environment', 'title' => 'Set environment'),
				),
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("poste/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', '<i class="icon-trash"></i>'),
					'url' => 'Yii::app()->createUrl("poste/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('class' => 'delete', 'data-original-title' => 'Suppression', 'title' => 'Suppression'),
				),
			),
		),
	)),
)); ?>
<?php $posteform = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'poste-form',
	'type' => 'horizontal',
	'action' => Yii::app()->createUrl('poste/create'),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $posteform->errorSummary(array($newposte)); ?>
	<?php echo $posteform->textFieldRow($newposte, 'routeur', array('size' => 60, 'maxlength' => 255)); ?>
	<?php echo $posteform->textFieldRow($newposte, 'hostname', array('size' => 60, 'maxlength' => 255)); ?>
	<?php echo $posteform->textFieldRow($newposte, 'numero_de_serie', array('size' => 60, 'maxlength' => 255)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
