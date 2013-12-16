<?php

class TagautoController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.tagauto.admin';
	public $createview = 'application.views.tagauto.create';
	public $updateview = 'application.views.tagauto.update';

	public function filters() {
		return array(
			'createAutoTag + create',
			'deleteAutoTag + delete',
			'adminAutoTag + admin',
			'exportAutoTag + export',
			'updateAutoTag + update, updateEditable',
		);
	}

	public function filterCreateAutoTag($filterChain) {
		if (Yii::app()->user->checkAccess("AutoTag.Create")) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("AutoTag.CreateGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			if ($user->hasGroup($_POST['Tagauto']['groupement_id'])) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterDeleteAutoTag($filterChain) {
		if (Yii::app()->user->checkAccess("AutoTag.Delete")) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("AutoTag.DeleteGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$model = $this->loadModel($_GET['id']);
			if ($model && $user->hasGroup($model->groupement_id)) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterAdminAutoTag($filterChain) { /* TODO Temporary until rename Tagauto -> AutoTag */
		if (Yii::app()->user->checkAccess("AutoTag.Admin") || Yii::app()->user->checkAccess("AutoTag.AdminGroup")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterExportAutoTag($filterChain) { /* TODO Temporary until rename Tagauto -> AutoTag */
		if (Yii::app()->user->checkAccess("AutoTag.Export")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterUpdateAutoTag($filterChain) {
		if (Yii::app()->user->checkAccess("AutoTag.Update")) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("AutoTag.UpdateGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			if (isset($_POST['pk'])) { // updateEditable request
				$id = $_POST['pk'];
			} elseif (isset($_GET['id'])) { // Normal update request
				$id = $_GET['id'];
			} else {
				throw new CHttpException(404, 'Unknown node.');
			}
			$model = $this->loadModel($id);
			if ($model && $user->hasGroup($model->groupement_id)) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public $defaultAction = 'admin';

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

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'newtagauto-form') {
			echo CActiveForm::validate(array($tagauto));
			Yii::app()->end();
		}

		if (isset($_POST['Tagauto'])) {
			$tagauto->attributes = $_POST['Tagauto'];
			if ($tagauto->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Tagauto " . $tagauto->_intname . " successfully created."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagauto->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Tagauto object " . $tagauto->_intname . "."));
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
			if ($tagauto->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Tagauto object " . $tagauto->_intname . " successfully updated."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagauto->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Tagauto object " . $tagauto->_intname . "."));
			}
		}

		$this->render($this->updateview, array(
			'tagauto' => $tagauto,
			'fait' => $fait,
			'newfait' => $newfait,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
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
