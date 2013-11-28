<?php
$this->pageTitle = Yii::t('app', 'Create File');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage File') => array('admin'),
	Yii::t('app', 'Create File'),
);
?>
<?php echo $this->renderPartial('application.views.file._form', array('file' => $file, 'prevUri' => $prevUri)); ?>