<?php

class FileController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.file.admin';
	public $createview = 'application.views.file.create';
	public $updateview = 'application.views.file.update';
	public $codaview = 'application.views.file.coda';
	public $mergeview = 'application.views.file.merge';
	public $exportview = 'application.views.file.export';

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'File');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('File.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = File::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("File.CodaAll") || (Yii::app()->user->checkAccess("File.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'file' => $model,
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
		$file = new File('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-form') {
		echo CActiveForm::validate(array($file));
			Yii::app()->end();
		}

		if (isset($_POST['File'])) {
			$file->attributes = $_POST['File'];
			$valid = true;
			$valid = $file->validate() && $valid;
			if ($valid) {
				if ($valid && $file->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "File " . $file->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $file->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating File object " . $file->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'file' => $file,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$file = File::model()->findByPk($_GET['id']);
		if ($file === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant File object.'));
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-form') {
			echo CActiveForm::validate(array($file));
			Yii::app()->end();
		}

		if (isset($_POST['File'])) {
			$file->attributes = $_POST['File'];
			$valid = true;
			$valid = $file->validate() && $valid;
			if ($valid) {
				if ($valid && $file->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "File object " . $file->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $file->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating File object " . $file->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'file' => $file,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionAdmin() {
		$model = new File('search');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['File']))
			$model->attributes = $_GET['File'];

		$this->render($this->adminview, array(
			'file' => $model,
		));
	}

	public function loadModel($id) {
		$model = File::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le file demandé n\'existe pas.');
		return $model;
	}
}
