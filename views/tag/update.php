<?php
$this->pageTitle = Yii::t('app', 'Update Tag');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Tag') => array('admin'),
	$tag->_intname => array('update','id' => $tag->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.tag._form', array('tag' => $tag, 'paramvalues' => $paramvalues, 'prevUri' => $prevUri)); ?>
