<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Gestion des utilisateurs') => array('admin'),
	$model->username => array('update', 'id' => $model->id),
	Yii::t('app', 'Modification'),
);

?>

<?php echo $this->renderPartial('application.views.user._form', array('model'=>$model, 'prevUri' => $prevUri)); ?>
