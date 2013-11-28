<?php
$this->pageTitle = Yii::t('app', 'Create Fait_groupement');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Fait_groupement') => array('admin'),
	Yii::t('app', 'Create Fait_groupement'),
);
?>
<?php echo $this->renderPartial('application.views.fait_groupement._form', array('fait_groupement' => $fait_groupement, 'prevUri' => $prevUri)); ?>