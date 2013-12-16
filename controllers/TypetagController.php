<?php

class TypetagController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.typetag.admin';
	public $createview = 'application.views.typetag.create';
	public $updateview = 'application.views.typetag.update';

	public $defaultAction = 'admin';

	/* TODO Temporary until Typetag is renamed to TagType */
	public function filters() {
		return array(
			'createTagType + create',
			'deleteTagType + delete',
			'adminTagType + admin',
			'exportTagType + export',
			'updateTagType + update, updateEditable',
		);
	}

	public function filterCreateTagType($filterChain) {
		if (Yii::app()->user->checkAccess("TagType.Create")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterDeleteTagType($filterChain) {
		if (Yii::app()->user->checkAccess("TagType.Delete")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterAdminTagType($filterChain) {
		if (Yii::app()->user->checkAccess("TagType.Admin")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterExportTagType($filterChain) {
		if (Yii::app()->user->checkAccess("TagType.Export")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterUpdateTagType($filterChain) {
		if (Yii::app()->user->checkAccess("TagType.Update")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

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
			if ($typetag->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Typetag object " . $typetag->_intname . " successfully updated."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $typetag->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Typetag object " . $typetag->_intname . "."));
			}
		}

		$this->render($this->updateview, array(
			'typetag' => $typetag,
			'tagparam' => $tagparam,
			'newtagparam' => $newtagparam,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionCreate() {
		$typetag = new Typetag('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'typetag-form') {
			echo CActiveForm::validate(array($typetag));
			Yii::app()->end();
		}

		if (isset($_POST['Typetag'])) {
			$typetag->attributes = $_POST['Typetag'];
			if ($typetag->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Typetag " . $typetag->_intname . " successfully created."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $typetag->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Typetag object " . $typetag->_intname . "."));
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
