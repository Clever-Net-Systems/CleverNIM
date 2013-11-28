<?php

class TypetagController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.typetag.admin';
	public $createview = 'application.views.typetag.create';
	public $updateview = 'application.views.typetag.update';
	public $codaview = 'application.views.typetag.coda';
	public $mergeview = 'application.views.typetag.merge';
	public $exportview = 'application.views.typetag.export';

	public function actionExport() {
		$model = new Typetag('search');
		$csv = "Nom;Classe;Description;Parametres\n";
		$dp = $model->search();
		$dp->setPagination(false);
		foreach($dp->getData() as $record) {
			$csv .= $record->nom . ';';
			$csv .= $record->classe . ';';
			$csv .= $record->description . ';';
			$csv .= implode(',', array_map(function ($p) { return $p->_intname; }, $record->parametre)) . ';';
			$csv .= "\n";
		}
		foreach (Yii::app()->log->routes as $route) { /* Disable rendering of yiidebugtb inside CSV file */
			if ($route instanceof XWebDebugRouter) {
				$route->enabled = false;
			}
		}
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename=Typetag_' . date('YmdHis') . '.csv');
		header('Cache-Control: max-age=0');
		echo $csv;
		Yii::app()->end();
	}

	public function actionAdmin() {
		$model = new Typetag('search');
		$newtypetag = new Typetag('create');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Typetag']))
			$model->attributes = $_GET['Typetag'];

		$this->render($this->adminview, array(
			'typetag' => $model,
			'newtypetag' => $newtypetag,
		));
	}

	public function actionUpdate($id) {
		$typetag = Typetag::model()->findByPk($_GET['id']);
		if ($typetag === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Typetag object.'));
		}
		$tagparam = new Tagparam('search');
		$tagparam->type_de_tag_id = $typetag->id;
		$newtagparam = new Tagparam('create');
		$newtagparam->type_de_tag_id = $typetag->id;

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'typetag-form') {
			echo CActiveForm::validate(array($typetag));
			Yii::app()->end();
		}

		if (isset($_POST['Typetag'])) {
			$typetag->attributes = $_POST['Typetag'];
			$valid = true;
			$valid = $typetag->validate() && $valid;
			if ($valid) {
				if ($valid && $typetag->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Typetag object " . $typetag->_intname . " successfully updated."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $typetag->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Typetag object " . $typetag->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->updateview, array(
			'typetag' => $typetag,
			'tagparam' => $tagparam,
			'newtagparam' => $newtagparam,
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
		$model = $this->loadModel($_GET['id'], 'Typetag');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Typetag.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Typetag::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Typetag.CodaAll") || (Yii::app()->user->checkAccess("Typetag.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'typetag' => $model,
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
		$typetag = new Typetag('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'typetag-form') {
		echo CActiveForm::validate(array($typetag));
			Yii::app()->end();
		}

		if (isset($_POST['Typetag'])) {
			$typetag->attributes = $_POST['Typetag'];
			$valid = true;
			$valid = $typetag->validate() && $valid;
			if ($valid) {
				if ($valid && $typetag->save(false)) {
					Yii::app()->user->setFlash('success', Yii::t('app', "Typetag " . $typetag->_intname . " successfully created."));
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $typetag->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Typetag object " . $typetag->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'typetag' => $typetag,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function loadModel($id) {
		$model = Typetag::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le typetag demandé n\'existe pas.');
		return $model;
	}

	public function actionDelete($id) {
		$model = $this->loadModel($id);
		if ($model->tags) {
			Yii::app()->user->setFlash('error', "Vous ne pouvez pas supprimer " . $model->_intname . " car des tags de ce type sont actifs.");
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
