<?php
$this->pageTitle = Yii::t('app', 'Statistics');
$this->breadcrumbs = array(
	Yii::t('app', 'Statistics'),
);
?>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>Database activity</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<div id="container">
				<?php
				$this->Widget('application.widgets.highcharts.HighchartsWidget', array(
					'options' => array(
						'chart' => array('type' => 'area'),
						'plotOptions' => array('area' => array(
							'stacking' => 'normal'),
						),
						'title' => array('text' => ''),
						'credits' => array('enabled' => false),
						'exporting' => array('enabled' => false),
						'xAxis' => array(
							'type' => 'datetime',
							'tickInterval' => 24 * 3600 * 1000,
							'tickWidth' => 0,
							'gridLineWidth' => 1,
							'labels' => array(
								'align' => 'left',
								'x' => 3,
								'y' => -3,
							),
						),
						'yAxis' => array(
							'title' => array('text' => 'Records')
						),
						'series' => array(
							array('name' => 'Creates', 'data' => array()),
							array('name' => 'Updates', 'data' => array()),
							array('name' => 'Deletes', 'data' => array()),
						)
					)
				));
				?>
			</div>
		</div>
	</div>
</div>
