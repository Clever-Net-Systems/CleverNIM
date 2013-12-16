<?php

class GroupementController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $createview = 'application.views.groupement.create';
	public $updateview = 'application.views.groupement.update';
	public $adminview = 'application.views.groupement.admin';

	/* TODO Temporary until Groupement is renamed to Group */
	public function filters() {
		return array(
			'createGroup + create',
			'deleteGroup + delete',
			'adminGroup + admin',
			'exportGroup + export',
			'updateGroup + update, updateEditable',
		);
	}

	public function filterCreateGroup($filterChain) {
		if (Yii::app()->user->checkAccess("Group.Create")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterDeleteGroup($filterChain) {
		if (Yii::app()->user->checkAccess("Group.Delete")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterAdminGroup($filterChain) {
		if (Yii::app()->user->checkAccess("Group.Admin")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterExportGroup($filterChain) {
		if (Yii::app()->user->checkAccess("Group.Export")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterUpdateGroup($filterChain) {
		if (Yii::app()->user->checkAccess("Group.Update")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public $defaultAction = 'admin';

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
			if ($groupement->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Groupement " . $groupement->_intname . " successfully created."));
				$this->redirect(array('admin', 'id' => $groupement->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Groupement object " . $groupement->_intname . "."));
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
			if ($groupement->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Groupement object " . $groupement->_intname . " successfully updated."));
				$this->redirect(array('admin', 'id' => $groupement->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Groupement object " . $groupement->_intname . "."));
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
