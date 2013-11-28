<?php

class ValeurparamController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.valeurparam.admin';
	public $createview = 'application.views.valeurparam.create';
	public $updateview = 'application.views.valeurparam.update';
	public $codaview = 'application.views.valeurparam.coda';
	public $mergeview = 'application.views.valeurparam.merge';
	public $exportview = 'application.views.valeurparam.export';

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'Valeurparam');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Valeurparam.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Valeurparam::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Valeurparam.CodaAll") || (Yii::app()->user->checkAccess("Valeurparam.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'valeurparam' => $model,
					));
				} else {
					throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
				}
			} else {
				throw new CHttpException(404, Yii::t('app', 'Unknown ID.'));
			}
		} else {
			throw new CHttpException(400, Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	public function actionCreate() {
		$valeurparam = new Valeurparam('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'valeurparam-form') {
		echo CActiveForm::validate(array($valeurparam));
			Yii::app()->end();
		}

		if (isset($_POST['Valeurparam'])) {
			$valeurparam->attributes = $_POST['Valeurparam'];
			$valid = true;
			$valid = $valeurparam->validate() && $valid;
			if ($valid) {
				if ($valid && $valeurparam->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Valeurparam " . $valeurparam->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $valeurparam->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Valeurparam object " . $valeurparam->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'valeurparam' => $valeurparam,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$valeurparam = Valeurparam::model()->findByPk($_GET['id']);
		if ($valeurparam === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Valeurparam object.'));
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'valeurparam-form') {
			echo CActiveForm::validate(array($valeurparam));
			Yii::app()->end();
		}

		if (isset($_POST['Valeurparam'])) {
			$valeurparam->attributes = $_POST['Valeurparam'];
			$valid = true;
			$valid = $valeurparam->validate() && $valid;
			if ($valid) {
				if ($valid && $valeurparam->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Valeurparam object " . $valeurparam->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $valeurparam->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Valeurparam object " . $valeurparam->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'valeurparam' => $valeurparam,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionAdmin() {
		$model = new Valeurparam('search');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Valeurparam']))
			$model->attributes = $_GET['Valeurparam'];

		$this->render($this->adminview, array(
			'valeurparam' => $model,
		));
	}

	public function loadModel($id) {
		$model = Valeurparam::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le valeurparam demandé n\'existe pas.');
		return $model;
	}
}
