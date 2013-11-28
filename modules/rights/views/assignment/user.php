<?php
$this->pageTitle = Yii::t('app', 'Assignations');
$this->breadcrumbs = array(
	'Gestion des droits'=>Rights::getBaseUrl(),
	Rights::t('core', 'Assignations')=>array('assignment/view'),
	$model->getName(),
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'assign-grid',
	'type' => 'striped bordered condensed',
	'dataProvider'=>$dataProvider,
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'template'=>"{items}",
	'emptyText'=>Rights::t('core', 'Pas de doits trouvés.'),
	'columns'=>array(
    			array(
    				'name'=>'type',
    				'header'=>Rights::t('core', 'Type'),
    				'type'=>'raw',
    				'value'=>'$data->getTypeText()',
    			),
    			array(
    				'name'=>'name',
    				'header'=>Rights::t('core', 'Nom'),
    				'type'=>'raw',
    				'value'=>'$data->getRealNameText()',
    			),
    			array(
    				'name'=>'name',
    				'header'=>Rights::t('core', 'Description'),
    				'type'=>'raw',
    				'value'=>'$data->getNameText()',
    			),
    			array(
    				'header'=>'&nbsp;',
    				'type'=>'raw',
    				'value'=>'$data->getRevokeAssignmentLink()',
    			),
			)
		)); ?>

	<br />
	<h3><?php echo Rights::t('core', 'Assigner un droit'); ?></h3>

	<?php if( $formModel!==null ): ?>
	<?php $this->renderPartial('_form', array(
		'model'=>$formModel,
		'itemnameSelectOptions'=>$assignSelectOptions,
	)); ?>
	<?php else: ?>
		<p class="info"><?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>
	<?php endif; ?>
