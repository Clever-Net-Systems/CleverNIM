<?php
$this->pageTitle = Yii::t('app', 'Delete Selection');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Selection') => array('admin'),
	Yii::t('app', 'Delete Selection'),
);
?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>Avertissement</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<p>Etes-vous sûr de vouloir supprimer <a class="codaPopupTrigger" rel="<?php echo $this->createUrl("selection/coda", array('id' => $model->id)); ?>" href="<?php echo $this->createUrl('selection/update', array('id' => $model->id)); ?>"><?php echo $model->_intname; ?></a> ?</p>
			<p>Attention! Les <?php echo count($objs); ?> éléments suivants seront supprimés en cascade.</p>
		</div>
	</div>
</div>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo $model->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
<?php if (count($objs) > 1) { ?><table class="simple">
	<thead>
		<tr><td class="left">Type</td><td class="center">Objet</td></tr>
	</thead>
	<tbody>
<?php foreach ($objs as $obj) { ?><tr><td class="center"><?php echo get_class($obj); ?></td><td><a class="codaPopupTrigger" rel="<?php echo $this->createUrl(get_class($obj) . "/coda", array('id' => $obj->id)); ?>" href="<?php echo $this->createUrl(get_class($obj) . '/update', array('id' => $obj->id)); ?>"><?php echo $obj->_intname; ?></a></td></tr>
	<?php } ?>	</tbody>
</table>
	<?php } ?>
		</div>
	</div>
</div>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'selection-form',
	'enableAjaxValidation'=>true,
)); ?>
<?php echo CHtml::hiddenField('prevUri', $prevUri); ?>	<div class="row buttons">
		<?php echo CHtml::submitButton((count($objs) > 1) ? ('Supprimer ce Selection et les ' . (count($objs) - 1) . ' éléments associés') : 'Supprimer ce Selection', array('name' => 'confirm')); ?>		<?php echo CHtml::link('Annuler la suppression', isset($prevUri) ? $prevUri : "/selection/admin"); ?>	</div>

		<?php $this->endWidget(); ?>
</div><!-- form -->
