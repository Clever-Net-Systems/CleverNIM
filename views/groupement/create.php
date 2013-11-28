<?php
$this->pageTitle = Yii::t('app', 'Create Groupement');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Groupement') => array('admin'),
	Yii::t('app', 'Create Groupement'),
);
?>
<?php echo $this->renderPartial('application.views.groupement._form', array('groupement' => $groupement, 'fait' => $fait, 'newfait' => $newfait, 'prevUri' => $prevUri)); ?>
