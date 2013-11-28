<?php
$this->pageTitle = Yii::t('app', 'Update Groupement');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Groupement') => array('admin'),
	$groupement->_intname => array('update','id' => $groupement->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.groupement._form', array('groupement' => $groupement, 'fait' => $fait, 'newfait' => $newfait, 'prevUri' => $prevUri)); ?>
