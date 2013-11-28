<?php
Yii::app()->clientScript->registerScript('initScript', "
function showHideParams() {
                $('div[class*=\"st_\"]').hide();
                $('.st_' + $('#File_hastype option:selected').val()).show(500);
}

jQuery().ready(function (){
                $('#File_hastype').change(showHideParams);
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
	<div class="widget_title clearfix"><h2><?php echo $file->isNewRecord ? 'Nouveau File' : $file->_intname; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'file-form',
	'enableAjaxValidation' => true,
)); ?>
<?php echo $form->errorSummary(array($file)); ?>

	<div class="row">
		<?php echo $form->labelEx($file, 'filename'); ?>
		<?php echo $form->textField($file, 'filename', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($file, 'filename'); ?>
		<p class="hint">Filename</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($file, 'size'); ?>
		<?php echo $form->textField($file, 'size', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($file, 'size'); ?>
		<p class="hint">File size</p>
	</div>
		<div class="row">
		<?php echo $form->labelEx($file, 'cdate'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name' => CHtml::activeName($file, 'cdate'),
			'value' => $file->attributes['cdate'],
                        'language' => 'fr',
                        'options' => array('showAnim' => 'fold', 'dateFormat' => 'yy-mm-dd', 'changeYear' => 'true', 'changeMonth' => 'true', 'showOtherMonths' => 'true', 'selectOtherMonths' => 'true'),
                )); ?>
		<?php echo $form->error($file, 'cdate'); ?>
		<p class="hint">Date of upload</p>
	</div>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton($file->isNewRecord ? 'Créer' : 'Sauvegarder'); ?> | <?php echo CHtml::link(Yii::t('app', 'Cancel'), $prevUri); ?>
	</div>

		<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>
