<?php
$this->pageTitle = Yii::t('app', 'Permissions');
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Permissions'),
);
?>

	<div class="widget_title clearfix"><h2>Permissions</h2>
		<ul class="">
			<li><?php echo CHtml::link("<span>Assignments</span>", CController::createUrl("assignment/view"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Permissions</span>", CController::createUrl("authItem/permissions"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Roles</span>", CController::createUrl("authItem/roles"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Tasks</span>", CController::createUrl("authItem/tasks"), array('class' => 'btn grey')); ?></li>
			<li><?php echo CHtml::link("<span>Operations</span>", CController::createUrl("authItem/operations"), array('class' => 'btn grey')); ?></li>
		</ul>
	</div>
	<div class="widget_body">
		<div class="widget_content">

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>'{items}',
		'emptyText'=>Rights::t('core', 'No authorization items found.'),
	    'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css'),
	    'cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css',
	    'template' => "{items}\n{summary}\n{pager}",
	    'pager' => array('class' => 'CLinkPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >'), 'header' => Yii::t('app', 'Aller à la page:')),
		'columns'=>$columns,
	)); ?>

	<p class="info">*) <?php echo Rights::t('core', 'Hover to see from where the permission is inherited.'); ?></p>

	<script type="text/javascript">

		/**
		* Attach the tooltip to the inherited items.
		*/
		jQuery('.inherited-item').rightsTooltip({
			title:'<?php echo Rights::t('core', 'Source'); ?>: '
		});

		/**
		* Hover functionality for rights' tables.
		*/
		$('#rights tbody tr').hover(function() {
			$(this).addClass('hover'); // On mouse over
		}, function() {
			$(this).removeClass('hover'); // On mouse out
		});

	</script>
		</div>
	</div>
