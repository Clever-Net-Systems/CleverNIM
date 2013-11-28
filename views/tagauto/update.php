<?php
$this->pageTitle = Yii::t('app', 'Update TagAuto');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Tagauto') => array('admin'),
	$tagauto->_intname => array('update','id' => $tagauto->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.tagauto._form', array('tagauto' => $tagauto, 'fait' => $fait, 'newfait' => $newfait, 'prevUri' => $prevUri)); ?>
