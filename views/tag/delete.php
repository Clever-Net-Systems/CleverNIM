<?php
$this->pageTitle = Yii::t('app', 'Delete Tag');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Tag') => array('admin'),
	Yii::t('app', 'Delete Tag'),
);
?>
			<p>Etes-vous sûr de vouloir supprimer <a class="codaPopupTrigger" rel="<?php echo $this->createUrl("tag/coda", array('id' => $model->id)); ?>" href="<?php echo $this->createUrl('tag/update', array('id' => $model->id)); ?>"><?php echo $model->_intname; ?></a> ?</p>
			<p>Attention! Les <?php echo count($objs); ?> éléments suivants seront supprimés en cascade.</p>
<?php if (count($objs) > 1) { ?><table class="simple">
	<thead>
		<tr><td class="left">Type</td><td class="center">Objet</td></tr>
	</thead>
	<tbody>
<?php foreach ($objs as $obj) { ?><tr><td class="center"><?php echo get_class($obj); ?></td><td><a class="codaPopupTrigger" rel="<?php echo $this->createUrl(get_class($obj) . "/coda", array('id' => $obj->id)); ?>" href="<?php echo $this->createUrl(get_class($obj) . '/update', array('id' => $obj->id)); ?>"><?php echo $obj->_intname; ?></a></td></tr>
	<?php } ?>	</tbody>
</table>
	<?php } ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tag-form',
	'enableAjaxValidation'=>true,
)); ?>
<?php echo CHtml::hiddenField('prevUri', $prevUri); ?>	<div class="row buttons">
		<?php echo CHtml::submitButton((count($objs) > 1) ? ('Supprimer ce Tag et les ' . (count($objs) - 1) . ' éléments associés') : 'Supprimer ce Tag', array('name' => 'confirm')); ?>		<?php echo CHtml::link('Annuler la suppression', isset($prevUri) ? $prevUri : "/tag/admin"); ?>	</div>

<?php $this->endWidget(); ?>
