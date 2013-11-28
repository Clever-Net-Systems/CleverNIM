<?php
$this->pageTitle = Yii::t('app', 'Update Profil');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Profil') => array('admin'),
	$profil->_intname => array('update','id' => $profil->id),
	'Update',
);
?>
<?php echo $this->renderPartial('application.views.profil._form', array('profil' => $profil, 'prevUri' => $prevUri)); ?>