<?php
$this->pageTitle = Yii::t('app', 'Create Tagauto');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Tagauto') => array('admin'),
	Yii::t('app', 'Create Tagauto'),
);
?>
<?php echo $this->renderPartial('application.views.tagauto._form', array('tagauto' => $tagauto, 'fait' => $fait, 'prevUri' => $prevUri)); ?>
