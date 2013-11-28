<?php
$this->pageTitle = Yii::t('app', 'Create Typetag');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Typetag') => array('admin'),
	Yii::t('app', 'Create Typetag'),
);
?>
<?php echo $this->renderPartial('application.views.typetag._form', array('typetag' => $typetag, 'prevUri' => $prevUri)); ?>
