<?php

class TagparamController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.tagparam.admin';
	public $createview = 'application.views.tagparam.create';
	public $updateview = 'application.views.tagparam.update';
	public $codaview = 'application.views.tagparam.coda';
	public $mergeview = 'application.views.tagparam.merge';
	public $exportview = 'application.views.tagparam.export';

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'Tagparam');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Tagparam.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Tagparam::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Tagparam.CodaAll") || (Yii::app()->user->checkAccess("Tagparam.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'tagparam' => $model,
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
		$tagparam = new Tagparam('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'tagparam-form') {
		echo CActiveForm::validate(array($tagparam));
			Yii::app()->end();
		}

		if (isset($_POST['Tagparam'])) {
			$tagparam->attributes = $_POST['Tagparam'];
			$valid = true;
			$valid = $tagparam->validate() && $valid;
			if ($valid) {
				if ($valid && $tagparam->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Tagparam " . $tagparam->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagparam->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Tagparam object " . $tagparam->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'tagparam' => $tagparam,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$tagparam = Tagparam::model()->findByPk($_GET['id']);
		if ($tagparam === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Tagparam object.'));
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'tagparam-form') {
			echo CActiveForm::validate(array($tagparam));
			Yii::app()->end();
		}

		if (isset($_POST['Tagparam'])) {
			$tagparam->attributes = $_POST['Tagparam'];
			$valid = true;
			$valid = $tagparam->validate() && $valid;
			if ($valid) {
				if ($valid && $tagparam->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Tagparam object " . $tagparam->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagparam->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Tagparam object " . $tagparam->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'tagparam' => $tagparam,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionAdmin() {
		$model = new Tagparam('search');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Tagparam']))
			$model->attributes = $_GET['Tagparam'];

		$this->render($this->adminview, array(
			'tagparam' => $model,
		));
	}

	public function loadModel($id) {
		$model = Tagparam::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le tagparam demandé n\'existe pas.');
		return $model;
	}
}
