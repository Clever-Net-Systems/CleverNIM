<?php

class AuditAdminController extends Controller {
	/**
	 * Filters
	 */
	public function filters() {
		return array(
			'rights'
		);
	}

	public $defaultAction = 'auditAdmin';
	public $layout='application.views.layouts.bootstrap';

	public function actionAuditAdmin() {
		$model = new AuditTrail('search');
		//$model->unsetAttributes();	// clear any default values
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if(isset($_GET['AuditTrail'])) {
			$model->attributes=$_GET['AuditTrail'];
		}
		$this->render('admin',array(
			'model'=>$model,
		));
	}
}
