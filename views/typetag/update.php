<?php
$this->pageTitle = Yii::t('app', 'Update TypeTag');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Typetag') => array('admin'),
	$typetag->_intname => array('update','id' => $typetag->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.typetag._form', array('typetag' => $typetag, 'tagparam' => $tagparam, 'newtagparam' => $newtagparam, 'prevUri' => $prevUri)); ?>
