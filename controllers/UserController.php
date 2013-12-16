<?php

class UserController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.user.admin';
	public $createview = 'application.views.user.create';
	public $updateview = 'application.views.user.update';
	public $updateselfview = 'application.views.user.updateself';

	/**
	 * Filters
	 */
	public function filters() {
		return array(
			'updateSelf + updateSelf',
			'rights'
		);
	}

	public function filterUpdateSelf($filterChain) {
		$user = $this->loadModel($_GET['id'], 'User');
		if (Yii::app()->user->checkAccess('User.UpdateSelf', array('id' => $user->id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	/**
	 * @var string the default controller action
	 */
	public $defaultAction = 'admin';

	public function actionExport() {
		$model = new User('search');
		$csv = "Utilisateur,Roles,Groupements,Date d'enregistrement,Date de derniere visite\n";
		$dp = $model->search();
		$dp->setPagination(false);
		foreach($dp->getData() as $record) {
			$csv .= $record->username . ',';
			$csv .= implode(';', array_keys(Rights::getassignedRoles($record->id))) . ',';
			$csv .= implode(';', array_map(function ($p) { return $p->_intname; }, $record->groupements)) . ',';
			$csv .= date("d.m.Y H:i:s", $record->createtime) . ',';
			$csv .= date("d.m.Y H:i:s", $record->lastvisit) . ',';
			$csv .= "\n";
		}
		foreach (Yii::app()->log->routes as $route) { /* Disable rendering of yiidebugtb inside CSV file */
			if ($route instanceof XWebDebugRouter) {
				$route->enabled = false;
			}
		}
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename=User_' . date('YmdHis') . '.csv');
		header('Cache-Control: max-age=0');
		echo $csv;
		Yii::app()->end();
	}

	public function actionAdmin() {
		$model = new User('search');
		$newuser = new User('create');
		//$model->unsetAttributes();  // clear any default values
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if(isset($_GET['User']))
			$model->attributes = $_GET['User'];

		$this->render($this->adminview, array(
			'model' => $model,
			'newuser' => $newuser,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model=new User;

		$this->performAjaxValidation($model);

		if(isset($_POST['User'])) {
			$model->attributes=$_POST['User'];
			$model->groupements = $model->groupementsIds;
			$model->activkey=md5(microtime().$model->password);
			$model->createtime=time();
			$model->lastvisit=time();
			$model->avatar="/media/Avatars/default_avatar.png";
			$model->password=md5($model->password);
			// Set language if not set by form (in case language is fixed)
			if (Yii::app()->config->get('langselect') == "Fixed") {
				$model->lang = Yii::app()->config->get('fixedlang');
			}
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Utilisateur " . $model->username . " créé avec succès");
				$this->redirect(array('admin','id'=>$model->id));
			} else {
				Yii::app()->user->setFlash('error', "Echec lors de la création de l'utilisateur " . $model->username);
			}
		}

		$model->groupementsIds = Yii::app()->db->createCommand("SELECT groupements_id FROM user_groupements WHERE users_id = :id")->queryColumn(array(":id" => $model->id));
		$this->render($this->createview,array(
			'model'=>$model,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdateSelf($id) {
		$model=$this->loadModel($id);
		$model->scenario = 'updateself';

		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$old_password = User::model()->findByPk($model->id);
			if (array_key_exists('groupementsIds', $_POST['User'])) {
				$model->groupements = $model->groupementsIds;
			} else {
				$model->groupements = array();
			}
			if ($old_password->password != $model->password) {
				$model->password = md5($model->password);
				$model->activkey = md5(microtime().$model->password);
			}
			if ($model->save()) {
				Yii::app()->user->setFlash('success', "Utilisateur " . $model->username . " modifié avec succès");
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
			} else {
				Yii::app()->user->setFlash('error', "Echec lors de la modification de l'utilisateur " . $model->username);
			}
		}

		$this->render($this->updateselfview,array(
			'model'=>$model,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate($id) {
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if (array_key_exists('groupementsIds', $_POST['User'])) {
				$model->groupements = $model->groupementsIds;
			} else {
				$model->groupements = array();
			}
			$old_password = User::model()->findByPk($model->id);
			if ($old_password->password != $model->password) {
				$model->password = md5($model->password);
				$model->activkey = md5(microtime().$model->password);
			}
			if ($model->save()) {
				Yii::app()->user->setFlash('success', "Utilisateur " . $model->username . " modifié avec succès");
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
			} else {
				Yii::app()->user->setFlash('error', "Echec lors de la modification de l'utilisateur " . $model->username);
			}
		}

		$model->groupementsIds = Yii::app()->db->createCommand("SELECT groupements_id FROM user_groupements WHERE users_id = :id")->queryColumn(array(":id" => $model->id));
		$this->render($this->updateview,array(
			'model'=>$model,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'L\'utilisateur demandé n\'existe pas.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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
