<?php
$this->breadcrumbs=array(
	$model->username => array('updateSelf','id'=>$model->id),
	'Modification',
);

?>
    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
		<h2><?php echo $model->_intname; ?></h2>
        </div>
        <div class="widget_body">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=> array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Les champs avec <span class="required">*</span> sont requis.</p>

	<?php echo $form->errorSummary(array($model)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20, 'disabled' => 'disabled')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

<?php
switch (Yii::app()->config->get('langselect')) {
case "Browser":
?>
	<div class="row">
		<?php echo $form->labelEx($model,'lang'); ?>
		<?php echo CHtml::textField('lang', Yii::app()->translate->acceptedLanguages[Yii::app()->translate->getLanguage()] . " (" . Yii::app()->translate->getLanguage() . ")", array('size'=>60, 'maxlength'=>128, 'disabled' => 'disabled')); ?>
		<?php echo $form->error($model,'lang'); ?>
		<p class="hint">Your current language is defined by your browser settings.</p>
	</div>
<?php
	break;
case "User":
	$langs = array();
	foreach (Yii::app()->config->get('authorizedlanguages') as $lang) {
		$langs[$lang] = Yii::app()->translate->acceptedLanguages[$lang];
	}
?>
	<div class="row">
		<?php echo $form->labelEx($model, 'lang'); ?>
		<?php echo $form->dropDownList($model, 'lang', $langs); ?>
		<?php echo $form->error($model, 'lang'); ?>
		<p class="hint">Choose a language from the list.</p>
	</div>
<?php
	break;
case "Fixed": default:
	break;
}
?>
	<div class="row">
		<?php echo CHtml::label('Roles', "Roles"); ?>
		<?php echo CHtml::textField('Roles', implode(' ', array_map(function($a) { return $a->name; }, Yii::app()->authManager->getAuthItems(2, Yii::app()->user->id))), array('size'=>60, 'maxlength'=>128, 'disabled' => 'disabled')); ?>
		<p class="hint">Your roles define your permissions.</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'avatar'); ?>
<?php	$this->widget('application.widgets.jqueryFileTree.jqueryFileTree', array(
			'name' => 'avatar',
			'form' => $form,
			'model' => $model,
			'class' => 'User',
	)); ?>
		<?php echo $form->error($model,'avatar'); ?>
		<p class="hint">The image to use as avatar</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Créer' : 'Sauvegarder'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
        </div>
    </div>
