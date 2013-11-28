<?php
$this->pageTitle = Yii::t('app', 'Appearance options');
$this->breadcrumbs = array(
	Yii::t('app', 'Appearance options'),
);
//Yii::app()->clientScript->registerCssFile('http://jqueryui.com/themes/base/ui.all.css', CClientScript::POS_HEAD);
?>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'appearance-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>Logos</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">

	<div class="row">
		<?php echo $form->labelEx($model,'logo'); ?>
<?php	$this->widget('application.widgets.jqueryFileTree.jqueryFileTree', array(
			'name' => 'logo',
			'form' => $form,
			'model' => $model,
			'class' => 'AppearanceForm',
	)); ?>
		<?php echo $form->error($model,'logo'); ?>
		<p class="hint">Logo</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'favicon'); ?>
<?php	$this->widget('application.widgets.jqueryFileTree.jqueryFileTree', array(
			'name' => 'favicon',
			'form' => $form,
			'model' => $model,
			'class' => 'AppearanceForm',
	)); ?>
		<?php echo $form->error($model,'favicon'); ?>
		<p class="hint">The favicon is the icon that appears in the URL bar and in the bookmarks</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Soumettre'); ?>
	</div>

			</div> <!-- form -->
		</div>
	</div>
</div>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>Theming</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
				<div class="row">
					<?php echo $form->labelEx($model, 'uitheme'); ?>
					<?php echo $form->hiddenField($model, 'uitheme'); ?>
					<?php $this->beginWidget('application.widgets.jqueryUIThemeSwitcher.jqueryUIThemeSwitcher', array()); ?>
					<?php $this->endWidget(); ?>
					<?php echo $form->error($model, 'uitheme'); ?>
					<p class="hint">The theme for the widgets</p>
				</div>

				<div class="row buttons">
					<?php echo CHtml::submitButton('Soumettre'); ?>
				</div>
			</div> <!-- form -->
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
