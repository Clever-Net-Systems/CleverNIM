<?php
$this->pageTitle = Yii::t('app', 'Create Tag');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Tag') => array('admin'),
	Yii::t('app', 'Create Tag'),
);
?>
<?php echo $this->renderPartial('application.views.tag._form', array('tag' => $tag, 'paramvalues' => $paramvalues, 'prevUri' => $prevUri)); ?>
