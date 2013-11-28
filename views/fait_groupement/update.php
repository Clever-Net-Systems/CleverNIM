<?php
$this->pageTitle = Yii::t('app', 'Update Fait Groupement');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Fait_groupement') => array('admin'),
	$fait_groupement->_intname => array('update','id' => $fait_groupement->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.fait_groupement._form', array('fait_groupement' => $fait_groupement, 'prevUri' => $prevUri)); ?>