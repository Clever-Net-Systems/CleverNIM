<?php
$this->pageTitle = Yii::t('app', 'Update Fait');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Fait') => array('admin'),
	$fait->_intname => array('update','id' => $fait->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.fait._form', array('fait' => $fait, 'prevUri' => $prevUri)); ?>