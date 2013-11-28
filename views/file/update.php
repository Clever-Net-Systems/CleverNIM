<?php
$this->pageTitle = Yii::t('app', 'Update File');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage File') => array('admin'),
	$file->_intname => array('update','id' => $file->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.file._form', array('file' => $file, 'prevUri' => $prevUri)); ?>