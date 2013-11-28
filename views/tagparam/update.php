<?php
$this->pageTitle = Yii::t('app', 'Update TagParam');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Tagparam') => array('admin'),
	$tagparam->_intname => array('update','id' => $tagparam->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.tagparam._form', array('tagparam' => $tagparam, 'prevUri' => $prevUri)); ?>