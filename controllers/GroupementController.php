<?php

class GroupementController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $createview = 'application.views.groupement.create';
	public $updateview = 'application.views.groupement.update';
	public $adminview = 'application.views.groupement.admin';
	public $codaview = 'application.views.groupement.coda';
	public $mergeview = 'application.views.groupement.merge';
	public $exportview = 'application.views.groupement.export';

	public function filters() {
		return array(
			'updateDeleteSelf + update, delete',
			'rights'
		);
	}

	public function filterUpdateDeleteSelf($filterChain) {
		$model = $this->loadModel($_GET['id'], 'Groupement');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Groupement.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Groupement::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Groupement.CodaAll") || (Yii::app()->user->checkAccess("Groupement.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'groupement' => $model,
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
		$model = Groupement::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le groupement demandé n\'existe pas.');
		return $model;
	}

	public function actionCreate() {
		$groupement = new Groupement('create');
		$fait = new Fait_groupement('search');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'groupement-form') {
		echo CActiveForm::validate(array($groupement));
			Yii::app()->end();
		}

		if (isset($_POST['Groupement'])) {
			$groupement->attributes = $_POST['Groupement'];
			$valid = true;
			$valid = $groupement->validate() && $valid;
			if ($valid) {
				if ($valid && $groupement->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Groupement " . $groupement->_intname . " successfully created."));
					$this->redirect(array('admin', 'id' => $groupement->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Groupement object " . $groupement->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'groupement' => $groupement,
			'fait' => $fait,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionUpdate($id) {
		$groupement = Groupement::model()->findByPk($_GET['id']);
		if ($groupement === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Groupement object.'));
		}
		$fait = new Fait_groupement('search');
		$fait->groupement_id = $groupement->id;
		$newfait = new Fait_groupement('create');
		$newfait->groupement_id = $groupement->id;

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'groupement-form') {
			echo CActiveForm::validate(array($groupement));
			Yii::app()->end();
		}

		if (isset($_POST['Groupement'])) {
			$groupement->attributes = $_POST['Groupement'];
			$valid = true;
			$valid = $groupement->validate() && $valid;
			if ($valid) {
				if ($valid && $groupement->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Groupement object " . $groupement->_intname . " successfully updated."));
					$this->redirect(array('admin', 'id' => $groupement->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Groupement object " . $groupement->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'groupement' => $groupement,
			'fait' => $fait,
			'newfait' => $newfait,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionExport() {
		$model = new Groupement('search');
		$csv = "Nom;Faits\n";
		$dp = $model->search();
		$dp->setPagination(false);
		foreach($dp->getData() as $record) {
			$csv .= $record->nom . ';';
			$csv .= implode(',', array_map(function ($p) { return $p->_intname; }, $record->faits)) . ';';
			$csv .= "\n";
		}
		foreach (Yii::app()->log->routes as $route) { /* Disable rendering of yiidebugtb inside CSV file */
			if ($route instanceof XWebDebugRouter) {
				$route->enabled = false;
			}
		}
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename=Groupement_' . date('YmdHis') . '.csv');
		header('Cache-Control: max-age=0');
		echo $csv;
		Yii::app()->end();
	}

	public function actionAdmin() {
		$model = new Groupement('search');
		$groupement = new Groupement('create');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Groupement']))
			$model->attributes = $_GET['Groupement'];

		$this->render($this->adminview, array(
			'groupement' => $model,
			'newgroupement' => $groupement,
		));
	}

	public function actionDelete($id) {
		$model = $this->loadModel($id);
		if ($model->tags || $model->tags_auto) {
			Yii::app()->user->setFlash('error', "Vous ne pouvez pas supprimer " . $model->_intname . " car des tags de ce groupement sont actifs.");
		} else {
			if ($model->delete()) {
				Yii::app()->user->setFlash('success', $model->_intname . " supprime avec succes.");
			} else {
				Yii::app()->user->setFlash('error', "Erreur lors de la suppression de " . $model->_intname);
			}
		}
		$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
	}
}
