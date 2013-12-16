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
    			'name'=>'Operations',
    			'header'=>Rights::t('core', 'Operations'),
    			'type'=>'raw',
    			'value'=>'implode("<br />", array_map(function ($t) { return $t->getName(); }, $data->getChildren()))',
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
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'task-form',
	'type' => 'vertical',
	'action' => Yii::app()->createUrl('rights/authItem/create', array('type' => CAuthItem::TYPE_TASK)),
	'enableAjaxValidation' => false,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($newmodel)); ?>
	<?php echo $form->textFieldRow($newmodel, 'name', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom de la tâche")); ?>
	<?php echo $form->textFieldRow($newmodel, 'description', array('size' => 60, 'maxlength' => 255, 'hint' => "La description de la tâche")); ?>
	<?php if( Rights::module()->enableBizRule===true ): ?>
		<?php echo $form->textFieldRow($newmodel, 'bizRule', array('size' => 60, 'maxlength' => 255, 'hint' => "Le code métier à exécuter lors de la validation de l'accès")); ?>
	<?php endif; ?>
	<?php if( Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData ): ?>
		<?php echo $form->textFieldRow($newmodel, 'data', array('size' => 60, 'maxlength' => 255, 'hint' => "Données additionnelles disponibles lors de l'exécution du code métier")); ?>
	<?php endif; ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
