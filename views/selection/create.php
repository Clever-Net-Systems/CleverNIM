<?php
$this->pageTitle = Yii::t('app', 'Create Selection');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Selection') => array('admin'),
	Yii::t('app', 'Create Selection'),
);
?>
<?php echo $this->renderPartial('application.views.selection._form', array('selection' => $selection, 'prevUri' => $prevUri)); ?>