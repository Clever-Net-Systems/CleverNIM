<?php
$this->pageTitle = Yii::t('app', 'Opérations');
$this->breadcrumbs = array(
	'Gestion des droits' => Rights::getBaseUrl(),
	Rights::t('core', 'Opérations'),
);
?>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'operation-grid',
	'type' => 'striped bordered condensed',
	'dataProvider'=>$dataProvider,
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'template'=>'{items}',
	'emptyText'=>Rights::t('core', 'Pas d\'opérations.'),
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	    'columns'=>array(
	    	array(
    			'name'=>'name',
    			'header'=>Rights::t('core', 'Name'),
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
    			'header'=>Rights::t('core', 'Business rule'),
    			'type'=>'raw',
    			'visible'=>Rights::module()->enableBizRule===true,
    		),
    		array(
    			'name'=>'data',
    			'header'=>Rights::t('core', 'Data'),
    			'type'=>'raw',
    			'visible'=>Rights::module()->enableBizRuleData===true,
    		),
    		array(
    			'header'=>'&nbsp;',
    			'type'=>'raw',
    			'value'=>'$data->getDeleteOperationLink()',
    		),
	    )
)); ?>
<span class="alert alert-info"><?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></span>
<br />
<br />
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'operation-form',
	'type' => 'vertical',
	'action' => Yii::app()->createUrl('rights/authItem/create', array('type' => CAuthItem::TYPE_OPERATION)),
	'enableAjaxValidation' => false,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($newmodel)); ?>
	<?php echo $form->textFieldRow($newmodel, 'name', array('size' => 60, 'maxlength' => 255, 'hint' => "Le nom du rôle")); ?>
	<?php echo $form->textFieldRow($newmodel, 'description', array('size' => 60, 'maxlength' => 255, 'hint' => "La description du rôle")); ?>
	<?php if( Rights::module()->enableBizRule===true ): ?>
		<?php echo $form->textFieldRow($newmodel, 'bizRule', array('size' => 60, 'maxlength' => 255, 'hint' => "Le code métier à exécuter lors de la validation de l'accès")); ?>
	<?php endif; ?>
	<?php if( Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData ): ?>
		<?php echo $form->textFieldRow($newmodel, 'data', array('size' => 60, 'maxlength' => 255, 'hint' => "Données additionnelles disponibles lors de l'exécution du code métier")); ?>
	<?php endif; ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>

	<p class="info"><?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></p>
		</div>
	</div>
