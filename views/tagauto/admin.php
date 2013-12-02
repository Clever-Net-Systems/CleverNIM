<?php
$this->pageTitle = Yii::t('app', 'Gestion des tags automatiques');
$this->breadcrumbs = array(
	Yii::t('app', 'Gestion des tags automatiques'),
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'tagauto-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $tagauto->search(),
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'selectableRows' => 2,
	'filter' => $tagauto,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href="/tagauto/export"><img src="/images/csv.png" alt="CSV Icon"></a.'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'name' => 'groupement_id',
			'filter' => Groupement::filterData('tags_auto'),
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->groupement->_intname), array("groupement/update", "id" => $data->groupement_id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("groupement/coda", array("id" => $data->groupement_id))))'
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
	'type' => 'inline',
	'action' => Yii::app()->createUrl('tagauto/create'),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($newtagauto)); ?>
	<?php echo $form->labelEx($newtagauto,'groupement_id'); ?>
	<?php echo $form->dropDownList($newtagauto,"groupement_id", CHtml::listData(Groupement::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>
	<?php echo $form->error($newtagauto,'groupement_id'); ?>
	<?php echo $form->textFieldRow($newtagauto, 'nom', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du tag automatique")); ?>
	<?php echo $form->textFieldRow($newtagauto, 'classe', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom de la classe Puppet à appliquer")); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
