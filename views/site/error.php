<?php
$this->pageTitle = Yii::t('app', "Error " . $code);
$this->breadcrumbs=array(
	'Error ' . $code,
);
?>
<div class="clear"></div>
<div class="grid_8 widget first">
	<div class="widget_title clearfix"><h2>Error <?php echo $code; ?></h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<p>Oops! Sorry, an error has occured.</p>
			<p>The error is: <?php echo CHtml::encode($message); ?></p>
		</div>
	</div>
</div>
<div class="grid_8 widget first">
	<div class="widget_title clearfix"><h2>Options</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<p><?php echo CHtml::link("Go back to the application", '/'); ?></p>
		</div>
	</div>
</div>
