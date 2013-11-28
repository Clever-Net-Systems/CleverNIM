<?php
$this->pageTitle = Yii::t('app', 'Analyse des donnees');
$this->breadcrumbs = array(
	Yii::t('app', 'Analyse des donnees'),
);
?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>Analyse des donnees</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<iframe name="olapframe" src="http://edupostes/jpivot/edupostes.jsp?query=bios" width="100%" height="1024" />
		</div>
	</div>
</div>
