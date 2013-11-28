<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#Profil_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#Profil_hastype').change(showHideParams);
                showHideParams();
});
");

$this->widget('application.widgets.eguiders.EGuider', array(
	'id'            => 'required_fields',
	'title'         => 'Required fields',
	'description'   => $this->renderPartial('application.views.site.eguiders.required_fields', null, true),
	'attachTo'      => 'label.required',
	'position'      => 3,
	'overlay'       => false,
	'xButton'       => true,
	'show'          => false
));
?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2><?php echo $profil->isNewRecord ? 'Nouveau Profil' : $profil->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'profil-form',
	'enableAjaxValidation' => true,
)); ?>
<?php echo $form->errorSummary(array($profil)); ?>


	<div class="row" id="profilsdiv">
		<?php echo $form->labelEx($profil, 'ecoles'); ?>
		<?php echo $form->listBox($profil, "ecolesIds", CHtml::listData(Ecole::model()->findAll(), "id", "_intname"), array("multiple" => "multiple")); ?>
		<?php echo $form->error($profil, 'ecoles'); ?>
		<p class="hint">Les écoles que ce profil peut administrer</p>
        </div>
	<div class="row" id="profilsdiv">
		<?php echo $form->labelEx($profil, 'groupements'); ?>
		<?php echo $form->listBox($profil, "groupementsIds", CHtml::listData(Groupement::model()->findAll(), "id", "_intname"), array("multiple" => "multiple")); ?>
		<?php echo $form->error($profil, 'groupements'); ?>
		<p class="hint">Les groupements que ce profil peut administrer</p>
        </div>
	<div class="row">
		<?php echo $form->labelEx($profil,'profileuser_id'); ?>
		<?php echo $form->dropDownList($profil,"profileuser_id", CHtml::listData(User::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>		<?php echo $form->error($profil,'profileuser_id'); ?>
		<p class="hint">The user this profile is linked to</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($profil->isNewRecord ? 'Créer' : 'Sauvegarder'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

		<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
