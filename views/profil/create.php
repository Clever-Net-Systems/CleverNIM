<?php
$this->pageTitle = Yii::t('app', 'Create Profil');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Profil') => array('admin'),
	Yii::t('app', 'Create Profil'),
);
?>
<?php echo $this->renderPartial('application.views.profil._form', array('profil' => $profil, 'prevUri' => $prevUri)); ?>