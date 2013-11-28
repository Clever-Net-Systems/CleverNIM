<?php
$this->pageTitle = Yii::t('app', 'Assignations');
$this->breadcrumbs = array(
	'Gestion des droits' => Rights::getBaseUrl(),
	Rights::t('core', 'Assignations'),
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'assign-grid',
	'type' => 'striped bordered condensed',
	'dataProvider'=>$dataProvider,
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'template'=>"{items}",
	'emptyText'=>Rights::t('core', 'Pas d\'utilisateurs trouvés.'),
	'columns'=>array(
		array(
			'name'=>'name',
			'header'=>Rights::t('core', 'Utilisateur'),
			'type'=>'raw',
			'value'=>'$data->getAssignmentNameLink()',
		     ),
		array(
			'name'=>'assignments',
			'header'=>Rights::t('core', 'Rôles assignés'),
			'type'=>'raw',
			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_ROLE)',
		     ),
		array(
			'name'=>'assignments',
			'header'=>Rights::t('core', 'Tâches assignées'),
			'type'=>'raw',
			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_TASK)',
		     ),
		array(
			'name'=>'assignments',
			'header'=>Rights::t('core', 'Opérations assignées'),
			'type'=>'raw',
			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)',
		     ),
		)
)); ?>

<span class="alert alert-info"><?php echo Rights::t('core', 'Cliquer sur un utilisateur pour modifier ses assignations.'); ?></span>
