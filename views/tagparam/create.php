<?php
$this->pageTitle = Yii::t('app', 'Create Tagparam');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Tagparam') => array('admin'),
	Yii::t('app', 'Create Tagparam'),
);
?>
<?php echo $this->renderPartial('application.views.tagparam._form', array('tagparam' => $tagparam, 'prevUri' => $prevUri)); ?>