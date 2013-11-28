<?php
$cs = Yii::app()->clientScript;

$this->breadcrumbs=array(
	'Gestion des utilisateurs'=>array('admin'),
	'Supprimer un utilisateur',
);

$this->menu=array(
	array('label'=>'Gestion des utilisateurs', 'url'=>array('admin')),
);

?>

<h1>Supprimer un utilisateur</h1>

<p>
Etes-vous sûr de vouloir supprimer l'utilisateur <a class="codaPopupTrigger" rel="<?php echo CController::createUrl("admin/coda", array('id' => $model->id)); ?>" href="<?php echo Yii::app()->createUrl('user/update', array('id' => $model->id)); ?>"><?php echo $model->username; ?></a> ?
</p>

<?php if (count($objs) > 1) { ?>
<p>Attention! Les <?php echo count($objs); ?> éléments suivants seront supprimés en cascade</p>
<table>
<th>Type</th><th>Objet</th>
<?php foreach ($objs as $obj) { ?>
<tr><td><?php echo get_class($obj); ?></td><td><a class="codaPopupTrigger" rel="<?php echo Yii::app()->createUrl(get_class($obj) . "/coda", array('id' => $obj->id)); ?>" href="<?php echo Yii::app()->createUrl(get_class($obj) . '/update', array('id' => $obj->id)); ?>"><?php echo $obj->_intname; ?></a></td></tr>
<?php } ?>
</table>
<?php } ?>

<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo CHtml::hiddenField('prevUri', $prevUri); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton((count($objs) > 1) ? ('Supprimer cet utilisateur et les ' . (count($objs) - 1) . ' éléments associés') : 'Supprimer cet utilisateur', array('name' => 'confirm')); ?>
		<?php echo CHtml::link('Annuler la suppression', $prevUri); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
