<?php

class FaitController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.fait.admin';
	public $createview = 'application.views.fait.create';
	public $updateview = 'application.views.fait.update';
	public $codaview = 'application.views.fait.coda';
	public $mergeview = 'application.views.fait.merge';
	public $exportview = 'application.views.fait.export';

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'Fait');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Fait.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Fait::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Fait.CodaAll") || (Yii::app()->user->checkAccess("Fait.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'fait' => $model,
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
		$fait = new Fait('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'fait-form') {
		echo CActiveForm::validate(array($fait));
			Yii::app()->end();
		}

		if (isset($_POST['Fait'])) {
			$fait->attributes = $_POST['Fait'];
			$valid = true;
			$valid = $fait->validate() && $valid;
			if ($valid) {
				if ($valid && $fait->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Fait " . $fait->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Fait object " . $fait->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'fait' => $fait,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$fait = Fait::model()->findByPk($_GET['id']);
		if ($fait === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Fait object.'));
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'fait-form') {
			echo CActiveForm::validate(array($fait));
			Yii::app()->end();
		}

		if (isset($_POST['Fait'])) {
			$fait->attributes = $_POST['Fait'];
			$valid = true;
			$valid = $fait->validate() && $valid;
			if ($valid) {
				if ($valid && $fait->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Fait object " . $fait->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Fait object " . $fait->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'fait' => $fait,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}
	public function actionAdmin() {
		$model = new Fait('search');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Fait']))
			$model->attributes = $_GET['Fait'];

		$this->render($this->adminview, array(
			'fait' => $model,
		));
	}

	public function loadModel($id) {
		$model = Fait::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le fait demandé n\'existe pas.');
		return $model;
	}
}
