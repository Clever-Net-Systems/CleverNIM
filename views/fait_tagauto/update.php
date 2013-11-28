<?php
$this->pageTitle = Yii::t('app', 'Update Fait TagAuto');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Fait_tagauto') => array('admin'),
	$fait_tagauto->_intname => array('update','id' => $fait_tagauto->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.fait_tagauto._form', array('fait_tagauto' => $fait_tagauto, 'prevUri' => $prevUri)); ?>