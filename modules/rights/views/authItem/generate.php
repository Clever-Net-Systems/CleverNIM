<?php
$this->pageTitle = Yii::t('app', 'Generate items');
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Generate items'),
);
?>

	<div class="widget_title clearfix"><h2>Roles</h2><?php echo CHtml::link("<span>Nouveau</span>", CController::createUrl("authItem/create", array('type' => CAuthItem::TYPE_ROLE)), array('class' => 'btn grey')); ?>
		<ul class="">
			<li><?php echo CHtml::link("<span>Assignments</span>", CController::createUrl("assignment/view"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Permissions</span>", CController::createUrl("authItem/permissions"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Roles</span>", CController::createUrl("authItem/roles"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Tasks</span>", CController::createUrl("authItem/tasks"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Operations</span>", CController::createUrl("authItem/operations"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Generate items</span>", CController::createUrl("authItem/generate/"), array('class' => 'btn grey')); ?></li>
		</ul>
	</div>
	<div class="widget_body">
		<div class="widget_content">

	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm'); ?>
			<div class="row">
				<table class="items generate-item-table" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="application-heading-row">
							<th colspan="3"><?php echo Rights::t('core', 'Application'); ?></th>
						</tr>
						<?php $this->renderPartial('_generateItems', array(
							'model'=>$model,
							'form'=>$form,
							'items'=>$items,
							'existingItems'=>$existingItems,
							'displayModuleHeadingRow'=>true,
							'basePathLength'=>strlen(Yii::app()->basePath),
						)); ?>
					</tbody>
				</table>
			</div>
			<div class="row">
   				<?php echo CHtml::link(Rights::t('core', 'Select all'), '#', array(
   					'onclick'=>"jQuery('.generate-item-table').find(':checkbox').attr('checked', 'checked'); return false;",
   					'class'=>'selectAllLink')); ?>
   				/
				<?php echo CHtml::link(Rights::t('core', 'Select none'), '#', array(
					'onclick'=>"jQuery('.generate-item-table').find(':checkbox').removeAttr('checked'); return false;",
					'class'=>'selectNoneLink')); ?>
			</div>
   			<div class="row">
				<?php echo CHtml::submitButton(Rights::t('core', 'Generate')); ?>
			</div>
		<?php $this->endWidget(); ?>
	</div>
		</div>
	</div>
