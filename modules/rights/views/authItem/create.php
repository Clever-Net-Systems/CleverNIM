<?php
$this->pageTitle = Rights::t('core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type'])));
$this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))),
);
?>

	<div class="widget_title clearfix"><h2><?php echo Rights::t('core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))); ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div class="wide form">
				<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>
			</div><!-- form -->
		</div>
	</div>
