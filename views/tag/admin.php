<?php
$this->pageTitle = Yii::t('app', 'Gestion des tags manuels');
$this->breadcrumbs = array(
	Yii::t('app', 'Gestion des tags manuels'),
);
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"pv_\"]').hide();
		//alert($('#Tag_type_de_tag_id option:selected').val());
                $('.pv_' + $('#Tag_type_de_tag_id option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Tag_type_de_tag_id').change(showHideParams);
                showHideParams();
});
");
?>

<?php $controller =$this; $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'tag-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $tag->search(),
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'selectableRows' => 2,
	'filter' => $tag,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href="/tag/export"><img src="/images/csv.png" alt="CSV Icon"></a>'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns' => array(
		array(
			'name' => 'groupement_id',
			'filter' => Groupement::filterData('tags'),
			'type' => 'raw',
			'value' => function($data, $row) use ($controller) { return $controller->renderPartial('application.views.groupement.link1', array('groupement' => $data->groupement), true); }
		),
		array(
			'name' => 'searchpostes',
			'filter' => null,
			'type' => 'raw',
			'value' => function($data, $row) use ($controller) { return $controller->renderPartial('application.views.poste.link', array('postes' => $data->postes), true); }
		),
		array(
			'name' => 'type_de_tag_id',
			'filter' => Typetag::filterData('tags'),
			'type' => 'raw',
			'value' => function($data, $row) use ($controller) { return $controller->renderPartial('application.views.typetag.link', array('typetag' => $data->type_de_tag), true); }
		),
		array(
			'name' => 'searchvaleurs',
			'filter' => null,
	 		'type' => 'raw',
			'value' => '$data->getAllvaleurss();'
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('tag-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{del}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("tag/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', '<i class="icon-trash"></i>'),
					'url' => 'Yii::app()->createUrl("tag/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('class' => 'delete', 'data-original-title' => 'Suppression', 'title' => 'Suppression'),
				),
			),
		),
	),
)); ?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'tag-form',
	'type' => 'vertical',
	'action' => Yii::app()->createUrl('tag/create'),
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($newtag)); ?>


	<?php echo $form->labelEx($newtag,'groupement_id'); ?>
	<?php echo $form->dropDownList($newtag,"groupement_id", CHtml::listData($newtag->groupementsOK(), "id", "_intname")); ?>		<?php echo $form->error($newtag,'groupement_id'); ?>
	<p class="hint">Groupement de restriction</p>
	<?php echo $form->labelEx($tag, 'postes'); ?>
	<?php $user = User::model()->findByPk(Yii::app()->user->id); ?>
	<?php echo $form->listBox($tag, "postesIds", CHtml::listData($user->getPostesOK(), "id", "_intname"), array("multiple" => "multiple", 'size' => 20)); ?>
	<p class="hint">Les postes associés à ce tag</p>
	<?php echo $form->labelEx($newtag,'type_de_tag_id'); ?>
	<?php echo $form->dropDownList($newtag,"type_de_tag_id", CHtml::listData(Typetag::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($newtag,'type_de_tag_id'); ?>
	<p class="hint">Le type de ce tag</p>

<?php foreach ($paramvalues as $pname => $pvalue) { ?>
	<div class="pv_none <?php echo "pv_" . $pvalue->parametre->type_de_tag->id . " "; ?>">
		<?php echo $form->labelEx($pvalue, $pvalue->parametre->_intname); ?>
		<?php echo $form->error($pvalue, "[$pname]valeur"); ?>
		<?php if ($pvalue->parametre->type == 2) { ?>
		<?php echo $form->dropDownList($pvalue,"[$pname]valeur", explode(',', $pvalue->parametre->possibles)); ?>
		<?php } elseif ($pvalue->parametre->type == 1) { ?>
		<?php echo $form->checkBox($pvalue,"[$pname]valeur"); ?>
		<?php } else { ?>
		<?php echo $form->textField($pvalue, "[$pname]valeur", array('size' => 60, 'maxlength' => 255)); ?>
		<?php } ?>
		<p class="hint"><?php echo $pvalue->parametre->description; ?></p>
	</div>
<?php } ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => $newtag->isNewRecord ? 'Créer' : 'Sauvegarder')); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
<?php $this->endWidget(); ?>
