<?php

class TagautoController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $codaview = 'application.views.tagauto.coda';
	public $mergeview = 'application.views.tagauto.merge';
	public $exportview = 'application.views.tagauto.export';
	public $adminview = 'application.views.tagauto.admin';
	public $createview = 'application.views.tagauto.create';
	public $updateview = 'application.views.tagauto.update';

	public function actionExport() {
		$model = new Tagauto('search');
		$csv = "Groupement,Nom,Classe,Faits\n";
		$dp = $model->search();
		$dp->setPagination(false);
		foreach($dp->getData() as $record) {
			$csv .= $record->groupement->_intname . ',';
			$csv .= $record->nom . ',';
			$csv .= $record->classe . ',';
			$csv .= implode(';', array_map(function ($p) { return $p->_intname; }, $record->faits)) . ',';
			$csv .= "\n";
		}
		foreach (Yii::app()->log->routes as $route) { /* Disable rendering of yiidebugtb inside CSV file */
			if ($route instanceof XWebDebugRouter) {
				$route->enabled = false;
			}
		}
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename=Tagauto_' . date('YmdHis') . '.csv');
		header('Cache-Control: max-age=0');
		echo $csv;
		Yii::app()->end();
	}

	public function actionAdmin() {
		$model = new Tagauto('search');
		$newtagauto = new Tagauto('create');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Tagauto']))
			$model->attributes = $_GET['Tagauto'];

		$this->render($this->adminview, array(
			'tagauto' => $model,
			'newtagauto' => $newtagauto,
		));
	}

	public function actionCreate() {
		$tagauto = new Tagauto('create');
		$fait = new Fait_tagauto('search');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'tagauto-form') {
		echo CActiveForm::validate(array($tagauto));
			Yii::app()->end();
		}

		if (isset($_POST['Tagauto'])) {
			$tagauto->attributes = $_POST['Tagauto'];
			$valid = true;
			$valid = $tagauto->validate() && $valid;
			if ($valid) {
				if ($valid && $tagauto->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Tagauto " . $tagauto->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagauto->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Tagauto object " . $tagauto->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'tagauto' => $tagauto,
			'fait' => $fait,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$tagauto = Tagauto::model()->findByPk($_GET['id']);
		if ($tagauto === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Tagauto object.'));
		}
		$fait = new Fait_tagauto('search');
		$fait->tag_id = $tagauto->id;
		$newfait = new Fait_tagauto('create');
		$newfait->tag_id = $tagauto->id;

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'tagauto-form') {
			echo CActiveForm::validate(array($tagauto));
			Yii::app()->end();
		}

		if (isset($_POST['Tagauto'])) {
			$tagauto->attributes = $_POST['Tagauto'];
			$valid = true;
			$valid = $tagauto->validate() && $valid;
			if ($valid) {
				if ($valid && $tagauto->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Tagauto object " . $tagauto->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagauto->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Tagauto object " . $tagauto->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'tagauto' => $tagauto,
			'fait' => $fait,
			'newfait' => $newfait,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'Tagauto');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Tagauto.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Tagauto::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Tagauto.CodaAll") || (Yii::app()->user->checkAccess("Tagauto.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'tagauto' => $model,
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

	public function loadModel($id) {
		$model = Tagauto::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le tagauto demandé n\'existe pas.');
		return $model;
	}

	public function actionDelete($id) {
		$model = $this->loadModel($id);
		if ($model->delete()) {
			Yii::app()->user->setFlash('success', $model->_intname . " supprime avec succes.");
		} else {
			Yii::app()->user->setFlash('error', "Erreur lors de la suppression de " . $model->_intname);
		}
		$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
	}
}
