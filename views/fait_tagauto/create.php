<?php
$this->pageTitle = Yii::t('app', 'Create Fait_tagauto');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Fait_tagauto') => array('admin'),
	Yii::t('app', 'Create Fait_tagauto'),
);
?>
<?php echo $this->renderPartial('application.views.fait_tagauto._form', array('fait_tagauto' => $fait_tagauto, 'prevUri' => $prevUri)); ?>