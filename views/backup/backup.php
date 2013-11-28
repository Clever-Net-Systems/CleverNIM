<?php
$this->pageTitle = Yii::t('app', 'Sauvegarde & restauration');
$this->breadcrumbs = array(
	Yii::t('app', 'Sauvegarde & restauration des données'),
);
?>
<div class="clear"></div>
<div class="grid_8 widget first">
	<div class="widget_title clearfix"><h2>Sauvegarde</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<p>Cliquez sur le bouton ci-dessous pour télécharger un fichier contenant l'ensemble des données de la base.</p>
<?php echo CHtml::beginForm() ?>
<?php echo CHtml::hiddenField('action', 'backup'); ?>
<?php echo CHtml::submitButton("Sauvegarder la base"); ?>
<?php echo CHtml::endForm() ?>
		</div>
	</div>
</div>
<div class="grid_8 widget first">
	<div class="widget_title clearfix"><h2>Restauration</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<p>Utilisez le formulaire ci-dessous pour restaurer une sauvegarde précédente. Attention! Cette opération remplacera le contenu entier de la base.</p>
<?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>
<?php echo CHtml::hiddenField('action', 'restore'); ?>
<?php echo CHtml::fileField('dump'); ?>
<?php echo CHtml::submitButton('Restaurer la base'); ?>
<?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>
