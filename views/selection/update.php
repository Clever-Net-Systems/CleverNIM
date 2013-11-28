<?php
$this->pageTitle = Yii::t('app', 'Update Selection');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Selection') => array('admin'),
	$selection->_intname => array('update','id' => $selection->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.selection._form', array('selection' => $selection, 'prevUri' => $prevUri)); ?>