<?php

class Fait_groupementController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.fait_groupement.admin';
	public $createview = 'application.views.fait_groupement.create';
	public $updateview = 'application.views.fait_groupement.update';
	public $codaview = 'application.views.fait_groupement.coda';
	public $mergeview = 'application.views.fait_groupement.merge';
	public $exportview = 'application.views.fait_groupement.export';

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'Fait_groupement');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Fait_groupement.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Fait_groupement::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Fait_groupement.CodaAll") || (Yii::app()->user->checkAccess("Fait_groupement.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'fait_groupement' => $model,
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
		$fait_groupement = new Fait_groupement('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'fait_groupement-form') {
		echo CActiveForm::validate(array($fait_groupement));
			Yii::app()->end();
		}

		if (isset($_POST['Fait_groupement'])) {
			$fait_groupement->attributes = $_POST['Fait_groupement'];
			$valid = true;
			$valid = $fait_groupement->validate() && $valid;
			if ($valid) {
				if ($valid && $fait_groupement->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Fait_groupement " . $fait_groupement->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait_groupement->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Fait_groupement object " . $fait_groupement->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'fait_groupement' => $fait_groupement,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$fait_groupement = Fait_groupement::model()->findByPk($_GET['id']);
		if ($fait_groupement === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Fait_groupement object.'));
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'fait_groupement-form') {
			echo CActiveForm::validate(array($fait_groupement));
			Yii::app()->end();
		}

		if (isset($_POST['Fait_groupement'])) {
			$fait_groupement->attributes = $_POST['Fait_groupement'];
			$valid = true;
			$valid = $fait_groupement->validate() && $valid;
			if ($valid) {
				if ($valid && $fait_groupement->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Fait_groupement object " . $fait_groupement->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait_groupement->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Fait_groupement object " . $fait_groupement->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'fait_groupement' => $fait_groupement,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionAdmin() {
		$model = new Fait_groupement('search');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Fait_groupement']))
			$model->attributes = $_GET['Fait_groupement'];

		$this->render($this->adminview, array(
			'fait_groupement' => $model,
		));
	}

	public function loadModel($id) {
		$model = Fait_groupement::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le fait_groupement demandé n\'existe pas.');
		return $model;
	}
}
