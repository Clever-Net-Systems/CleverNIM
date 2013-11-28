<?php
$this->pageTitle = Rights::t('core', 'Update :name', array(':name'=>$model->name, ':type'=>Rights::getAuthItemTypeName($model->type)));
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::getAuthItemTypeNamePlural($model->type)=>Rights::getAuthItemRoute($model->type),
	$model->name,
);
?>

<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$parentDataProvider,
	'template'=>'{items}',
	'hideHeader'=>true,
	'emptyText'=>Rights::t('core', 'This item has no parents.'),
	'htmlOptions'=>array('class'=>'grid-view parent-table mini'),
	'columns'=>array(
		array(
			'name'=>'name',
			'header'=>Rights::t('core', 'Name'),
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'name-column'),
			'value'=>'$data->getNameLink()',
		),
		array(
			'name'=>'type',
			'header'=>Rights::t('core', 'Type'),
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'type-column'),
			'value'=>'$data->getTypeText()',
		),
		array(
			'header'=>'&nbsp;',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'actions-column'),
			'value'=>'',
		),
	)
)); ?>
<h2><?php echo Rights::t('core', 'Children'); ?></h2>
<?php if( $childFormModel!==null ): ?>
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<?php foreach ($childSelectOptions as $type => $items) {
		foreach($items as $item => $description) {
			echo CHtml::checkBox("child[" . $item . "]", false); echo "[" . $type . "] " . $item . " (" . $description . ")"; echo "<br />";
		}
	} ?>
	<?php //echo $form->dropDownList($childFormModel, 'itemname', $childSelectOptions); ?>
	<?php //echo $form->error($childFormModel, 'itemname'); ?>
	&nbsp;&nbsp;<?php echo CHtml::submitButton(Rights::t('core', 'Add')); ?>
	<?php $this->endWidget(); ?>
<?php else: ?>
	<p class="info"><?php echo Rights::t('core', 'No children available to be added to this item.'); ?>
<?php endif; ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$childDataProvider,
	'template'=>'{items}',
	'hideHeader'=>true,
	'emptyText'=>Rights::t('core', 'This item has no children.'),
	'htmlOptions'=>array('class'=>'grid-view parent-table mini'),
	'columns'=>array(
		array(
			'name'=>'name',
			'header'=>Rights::t('core', 'Name'),
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'name-column'),
			'value'=>'$data->getRealNameLink() . " (" . $data->description . ")"',
		     ),
		array(
			'name'=>'type',
			'header'=>Rights::t('core', 'Type'),
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'type-column'),
			'value'=>'$data->getTypeText()',
		     ),
		array(
			'header'=>'&nbsp;',
			'type'=>'raw',
			'htmlOptions'=>array('class'=>'actions-column'),
			'value'=>'$data->getRemoveChildLink()',
	     ),
	)
)); ?>
