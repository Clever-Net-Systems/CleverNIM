<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Gestion des utilisateurs') => array('admin'),
	Yii::t('app', 'Créer un utilisateur'),
);

?>

<?php echo $this->renderPartial('application.views.user._form', array('model'=>$model, 'prevUri' => $prevUri)); ?>
