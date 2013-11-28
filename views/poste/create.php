<?php
$this->pageTitle = Yii::t('app', 'Create Poste');
$this->breadcrumbs = array(
	Yii::t('app', 'Manage Poste') => array('admin'),
	Yii::t('app', 'Create Poste'),
);
?>
<?php echo $this->renderPartial('application.views.poste._form', array('poste' => $poste, 'prevUri' => $prevUri)); ?>
