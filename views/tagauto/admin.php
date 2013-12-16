<?php
$this->pageTitle = Yii::t('app', 'Gestion des tags automatiques');
$this->breadcrumbs = array(
	Yii::t('app', 'Gestion des tags automatiques'),
);
?>

<?php $controller = $this; $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'tagauto-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $tagauto->search(),
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'selectableRows' => 2,
	'filter' => $tagauto,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href="/tagauto/export"><img src="/images/csv.png" alt="CSV Icon"></a>.'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'name' => 'groupement_id',
			'filter' => Groupement::filterData('tags_auto'),
			'type' => 'raw',
			'value' => function($data, $row) use ($controller) { return $controller->renderPartial('application.views.groupement.link1', array('groupement' => $data->groupement), true); }
		),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'nom',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('tagauto/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Tagauto'),
			)               
		     ),
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'classe',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('tagauto/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'Tagauto'),
			)               
		     ),
		array(
			'name' => 'searchfaits',
			'filter' => null,
	 		'type' => 'raw',
			'value' => '$data->getAllfaitss();'
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('tagauto-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{del}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("tagauto/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', '<i class="icon-trash"></i>'),
					'url' => 'Yii::app()->createUrl("tagauto/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('class' => 'delete', 'data-original-title' => 'Suppression', 'title' => 'Suppression'),
				),
			),
		),
	),
)); ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'newtagauto-form',
	'type' => 'horizontal',
	'action' => Yii::app()->createUrl('tagauto/create'),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($newtagauto)); ?>
	<?php $user = User::model()->findByPk(Yii::app()->user->id); ?>
	<?php echo $form->dropDownListRow($newtagauto,"groupement_id", CHtml::listData($user->groupements, "id", "_intname"), array('hint' => 'The restriction group')); ?>
	<?php echo $form->textFieldRow($newtagauto, 'nom', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du tag automatique")); ?>
	<?php echo $form->textFieldRow($newtagauto, 'classe', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom de la classe Puppet à appliquer")); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
