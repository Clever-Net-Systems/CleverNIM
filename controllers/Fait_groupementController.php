<?php

class Fait_groupementController extends Controller {
	/* Access rights are those for Groups */
	public function filters() {
		return array(
			'createFact + create',
			'deleteFact + delete',
		);
	}

	public function filterCreateFact($filterChain) {
		if (Yii::app()->user->checkAccess("Group.Create")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterDeleteFact($filterChain) {
		if (Yii::app()->user->checkAccess("Group.Delete")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public $defaultAction = 'create';

	public function actionCreate() {
		$fait_groupement = new Fait_groupement('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'fait_groupement-form') {
			echo CActiveForm::validate(array($fait_groupement));
			Yii::app()->end();
		}

		if (isset($_POST['Fait_groupement'])) {
			$fait_groupement->attributes = $_POST['Fait_groupement'];
			if ($fait_groupement->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Fact " . $fait_groupement->_intname . " successfully added to group " . $fait_groupement->groupement->_intname));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error adding fact " . $fait_groupement->_intname . " to group " . $fait_groupement->groupement->_intname));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
			}
		}
		$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
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

	public function loadModel($id) {
		$model = Fait_groupement::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le fait_groupement demandé n\'existe pas.');
		return $model;
	}
}
