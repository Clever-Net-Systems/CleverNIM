<?php
$this->pageTitle = Yii::t('app', 'Create Valeurparam');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Valeurparam') => array('admin'),
	Yii::t('app', 'Create Valeurparam'),
);
?>
<?php echo $this->renderPartial('application.views.valeurparam._form', array('valeurparam' => $valeurparam, 'prevUri' => $prevUri)); ?>