<?php

class Fait_tagautoController extends Controller {
	/* Access rights are those for AutoTag update */
	public function filters() {
		return array(
			'createFact + create',
			'deleteFact + delete',
		);
	}

	public function filterCreateFact($filterChain) {
		if (Yii::app()->user->checkAccess("AutoTag.Update")) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("AutoTag.UpdateGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$model = Tagauto::model()->findByPk($_POST['Fait_tagauto']['tag_id']);
			if ($model && $user->hasGroup($model->groupement_id)) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterDeleteFact($filterChain) {
		if (Yii::app()->user->checkAccess("AutoTag.Update")) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("AutoTag.UpdateGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$model = Fait_tagauto::model()->findByPk($_GET['id']);
			if ($model && $user->hasGroup($model->tag->groupement_id)) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public $defaultAction = 'create';

	public function actionCreate() {
		$fait_tagauto = new Fait_tagauto('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'fait_tagauto-form') {
			echo CActiveForm::validate(array($fait_tagauto));
			Yii::app()->end();
		}

		if (isset($_POST['Fait_tagauto'])) {
			$fait_tagauto->attributes = $_POST['Fait_tagauto'];
			if ($fait_tagauto->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Fait_tagauto " . $fait_tagauto->_intname . " successfully created."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait_tagauto->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Fait_tagauto object " . $fait_tagauto->_intname . "."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait_tagauto->id));
			}
		}
		$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $fait_tagauto->id));
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
		$model = Fait_tagauto::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le fait_tagauto demandé n\'existe pas.');
		return $model;
	}
}
