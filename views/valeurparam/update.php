<?php
$this->pageTitle = Yii::t('app', 'Update ValeurParam');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Valeurparam') => array('admin'),
	$valeurparam->_intname => array('update','id' => $valeurparam->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.valeurparam._form', array('valeurparam' => $valeurparam, 'prevUri' => $prevUri)); ?>