<?php

class SelectionController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.selection.admin';
	public $createview = 'application.views.selection.create';
	public $updateview = 'application.views.selection.update';
	public $codaview = 'application.views.selection.coda';
	public $mergeview = 'application.views.selection.merge';
	public $exportview = 'application.views.selection.export';

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'Selection');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Selection.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Selection::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Selection.CodaAll") || (Yii::app()->user->checkAccess("Selection.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'selection' => $model,
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
		$selection = new Selection('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'selection-form') {
		echo CActiveForm::validate(array($selection));
			Yii::app()->end();
		}

		if (isset($_POST['Selection'])) {
			$selection->attributes = $_POST['Selection'];
			$valid = true;
			$valid = $selection->validate() && $valid;
			if ($valid) {
				if ($valid && $selection->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Selection " . $selection->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $selection->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Selection object " . $selection->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'selection' => $selection,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$selection = Selection::model()->findByPk($_GET['id']);
		if ($selection === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Selection object.'));
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'selection-form') {
			echo CActiveForm::validate(array($selection));
			Yii::app()->end();
		}

		if (isset($_POST['Selection'])) {
			$selection->attributes = $_POST['Selection'];
			$valid = true;
			$valid = $selection->validate() && $valid;
			if ($valid) {
				if ($valid && $selection->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Selection object " . $selection->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $selection->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Selection object " . $selection->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'selection' => $selection,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionAdmin() {
		$model = new Selection('search');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Selection']))
			$model->attributes = $_GET['Selection'];

		$this->render($this->adminview, array(
			'selection' => $model,
		));
	}

	public function loadModel($id) {
		$model = Selection::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le selection demandé n\'existe pas.');
		return $model;
	}
}
