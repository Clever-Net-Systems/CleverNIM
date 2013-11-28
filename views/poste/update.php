<?php
$this->pageTitle = Yii::t('app', 'Update Poste');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Poste') => array('admin'),
	$poste->_intname => array('update','id' => $poste->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.poste._form', array('poste' => $poste, 'prevUri' => $prevUri)); ?>
