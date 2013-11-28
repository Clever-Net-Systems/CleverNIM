<?php
$this->pageTitle = Yii::t('app', 'Stats PuppetDB');
$this->breadcrumbs = array(
	Yii::t('app', 'Stats PuppetDB'),
);
?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>Stats PuppetDB</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<iframe name="olapframe" src="http://volt.ceti.etat-ge.ch:9090/" width="920" height="1450" />
		</div>
	</div>
</div>
