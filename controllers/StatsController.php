<?php

class StatsController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'application.views.layouts.cchome';

	/**
	 * Filters
	 */
	public function filters() {
		return array(
			'rights'
		);
	}

	/**
	 * @var string the default controller action
	 */
	public $defaultAction = 'main';

	/**
	 * Returns data for the DB activity chart
	 */
	public function actionDBActivityData() {
		if (Yii::app()->request->isAjaxRequest) {
			$json = array();
			$audits = Yii::app()->db->createCommand()->select('year(stamp) as y, month(stamp) as m, day(stamp) as d, count(*) as c')->from('audit_trail')->where('action = "CREATE"')->group('y, m, d')->query();
			foreach ($audits as $audit) {
				$date = $audit['y'] . "-" . $audit['m'] . "-" . $audit['d'];
				$json['create'][$date] = (int)$audit['c'];
			}
			$audits = Yii::app()->db->createCommand()->select('year(stamp) as y, month(stamp) as m, day(stamp) as d, count(*) as c')->from('audit_trail')->where('action = "UPDATE"')->group('y, m, d')->query();
			foreach ($audits as $audit) {
				$date = $audit['y'] . "-" . $audit['m'] . "-" . $audit['d'];
				$json['update'][$date] = (int)$audit['c'];
			}
			$audits = Yii::app()->db->createCommand()->select('year(stamp) as y, month(stamp) as m, day(stamp) as d, count(*) as c')->from('audit_trail')->where('action = "DELETE"')->group('y, m, d')->query();
			foreach ($audits as $audit) {
				$date = $audit['y'] . "-" . $audit['m'] . "-" . $audit['d'];
				$json['delete'][$date] = (int)$audit['c'];
			}
			$this->layout = false;
			header('Content-type: application/json');
			//$json = array(1 => 42, 2 => 23, 3 => 24);
			echo json_encode($json);
			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * This is the default 'main' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionMain() {
		$this->render('application.views.stats.main');
	}
}
