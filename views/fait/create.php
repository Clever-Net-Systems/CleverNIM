<?php
$this->pageTitle = Yii::t('app', 'Create Fait');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Fait') => array('admin'),
	Yii::t('app', 'Create Fait'),
);
?>
<?php echo $this->renderPartial('application.views.fait._form', array('fait' => $fait, 'prevUri' => $prevUri)); ?>