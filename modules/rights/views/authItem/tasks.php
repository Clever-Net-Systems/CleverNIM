<?php
$this->pageTitle = Yii::t('app', 'Tâches');
$this->breadcrumbs = array(
	'Gestion des droits' => Rights::getBaseUrl(),
	Rights::t('core', 'Tâches'),
);
?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'task-grid',
	'type' => 'striped bordered condensed',
	'dataProvider'=>$dataProvider,
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'template'=>'{items}',
	'emptyText'=>Rights::t('core', 'Pas de tâches.'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	    'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>Rights::t('core', 'Nom'),
    			'type'=>'raw',
    			'value'=>'$data->getGridNameLink()',
    		),
    		array(
    			'name'=>'description',
    			'header'=>Rights::t('core', 'Description'),
    			'type'=>'raw',
    		),
    		array(
    			'name'=>'bizRule',
    			'header'=>Rights::t('core', 'Règle métier'),
    			'type'=>'raw',
    			'visible'=>Rights::module()->enableBizRule===true,
    		),
    		array(
    			'name'=>'data',
    			'header'=>Rights::t('core', 'Données'),
    			'type'=>'raw',
    			'visible'=>Rights::module()->enableBizRuleData===true,
    		),
    		array(
    			'header'=>'&nbsp;',
    			'type'=>'raw',
    			'value'=>'$data->getDeleteTaskLink()',
    		),
	    )
)); ?>

<span class="alert alert-info"><?php echo Rights::t('core', 'Les valeurs entre crochets montrent combien d\'enfants chaque rôle possède.'); ?></span>
<br />
<br />
