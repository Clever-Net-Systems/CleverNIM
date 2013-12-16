<?php

class TagparamController extends Controller {
	/* Access rights are those for TagTypes */
	public function filters() {
		return array(
			'createTagparam + create',
			'deleteTagparam + delete',
		);
	}

	public function filterCreateTagparam($filterChain) {
		if (Yii::app()->user->checkAccess("TagType.Create")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterDeleteTagparam($filterChain) {
		if (Yii::app()->user->checkAccess("TagType.Delete")) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public $defaultAction = 'create';

	public function actionCreate() {
		$tagparam = new Tagparam('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'tagparam-form') {
			echo CActiveForm::validate(array($tagparam));
			Yii::app()->end();
		}

		if (isset($_POST['Tagparam'])) {
			$tagparam->attributes = $_POST['Tagparam'];
			if ($tagparam->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Tagparam " . $tagparam->_intname . " successfully created."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagparam->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Tagparam object " . $tagparam->_intname . "."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagparam->id));
			}
		}
		$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $tagparam->id));
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
		$model = Tagparam::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le tagparam demandé n\'existe pas.');
		return $model;
	}
}
