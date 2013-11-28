<?php

class Fait_tagautoController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.fait_tagauto.admin';
	public $createview = 'application.views.fait_tagauto.create';
	public $updateview = 'application.views.fait_tagauto.update';
	public $codaview = 'application.views.fait_tagauto.coda';
	public $mergeview = 'application.views.fait_tagauto.merge';
	public $exportview = 'application.views.fait_tagauto.export';

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'Fait_tagauto');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Fait_tagauto.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Fait_tagauto::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Fait_tagauto.CodaAll") || (Yii::app()->user->checkAccess("Fait_tagauto.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'fait_tagauto' => $model,
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
		$fait_tagauto = new Fait_tagauto('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'fait_tagauto-form') {
		echo CActiveForm::validate(array($fait_tagauto));
			Yii::app()->end();
		}

		if (isset($_POST['Fait_tagauto'])) {
			$fait_tagauto->attributes = $_POST['Fait_tagauto'];
			$valid = true;
			$valid = $fait_tagauto->validate() && $valid;
			if ($valid) {
				if ($valid && $fait_tagauto->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Fait_tagauto " . $fait_tagauto->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait_tagauto->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Fait_tagauto object " . $fait_tagauto->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'fait_tagauto' => $fait_tagauto,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$fait_tagauto = Fait_tagauto::model()->findByPk($_GET['id']);
		if ($fait_tagauto === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Fait_tagauto object.'));
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'fait_tagauto-form') {
			echo CActiveForm::validate(array($fait_tagauto));
			Yii::app()->end();
		}

		if (isset($_POST['Fait_tagauto'])) {
			$fait_tagauto->attributes = $_POST['Fait_tagauto'];
			$valid = true;
			$valid = $fait_tagauto->validate() && $valid;
			if ($valid) {
				if ($valid && $fait_tagauto->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Fait_tagauto object " . $fait_tagauto->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait_tagauto->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Fait_tagauto object " . $fait_tagauto->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'fait_tagauto' => $fait_tagauto,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionAdmin() {
		$model = new Fait_tagauto('search');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Fait_tagauto']))
			$model->attributes = $_GET['Fait_tagauto'];

		$this->render($this->adminview, array(
			'fait_tagauto' => $model,
		));
	}

	public function loadModel($id) {
		$model = Fait_tagauto::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le fait_tagauto demandé n\'existe pas.');
		return $model;
	}
}
