<div id="box">
	<div class="wide form">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'registration-form',
			'enableAjaxValidation'=>true,
			'htmlOptions' => array('enctype'=>'multipart/form-data'),
		)); ?>

		<p class="note"><?php echo 'Fields with <span class="required">*</span> are required.'; ?></p>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
			<p class="hint">Your username.</p>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
			<p class="hint">Minimal password length 4 symbols.</p>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'verifyPassword'); ?>
			<?php echo $form->passwordField($model,'verifyPassword'); ?>
			<?php echo $form->error($model,'verifyPassword'); ?>
			<p class="hint">Please type your password again.</p>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?>
			<p class="hint">Please enter a valid e-mail address. You will receive a validation email.</p>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'verifyCode'); ?>
			<?php $this->widget('CCaptcha', array('imageOptions' => array('style' => 'position: static; top: 0px;'), 'buttonOptions' => array('style' => 'position: relative; top: -20px;'))); ?>
			<?php echo $form->textField($model,'verifyCode', array('style' => 'float: left; clear:left; margin-left: 110px; margin-top: 10px;')); ?>
			<?php echo $form->error($model,'verifyCode'); ?>
			<p class="hint">Please enter the letters as they are shown in the image above (letters are not case-sensitive).</p>
		</div>

		<div class="row submit">
			<?php echo CHtml::submitButton("Register"); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>
