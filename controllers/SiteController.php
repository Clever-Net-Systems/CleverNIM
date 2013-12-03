<?php

class SiteController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $loginlayout = "application.views.layouts.login";
	public $loginview = "application.views.site.login";

	public function allowedActions() {
		return 'index, login, page, novelllogin';
	}

	public function actionHome() {
		$this->render('application.views.site.home');
	}

	public function actionNovelllogin() {
		$identity = new NovellIdentity();
		$identity->authenticate();
		Yii::app()->user->login($identity, 0);
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionLogin() {
		if (Yii::app()->user->isGuest) {
			$this->layout = $this->loginlayout;
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastVisit();
					if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
						$this->redirect(Yii::app()->user->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render($this->loginview,array('model'=>$model));
		} else
			$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Displays the options page
	 */
	public function actionOptions() {
		if (Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->createUrl('user/login'));
		}
		$model = new OptionsForm;
		if(isset($_POST['OptionsForm'])) {
			$model->attributes = $_POST['OptionsForm'];
			if ($model->validate()) {
				Yii::app()->user->setFlash('success', "Vos options ont été sauvegardées");
				$this->refresh();
			}
		}
		$this->render('options', array('model' => $model));
	}

	public function actionRestartapache() {
		$output = "";
		if (isset($_POST['yt0']) && ($_POST['yt0'] == "Redémarrer")) {
			exec("/usr/bin/sudo /usr/local/bin/restart_apache.sh", $output, $errorcode);
			if ($errorcode != 0) {
				$output = "<p>Error restarting Apache (code $errorcode)</p>";
			}
		}
		$this->render('restartapache', array('output' => $output));
	}

	public function actionSyncmanifests() {
		$output = "";
		if (isset($_POST['yt0']) && ($_POST['yt0'] == "Synchroniser")) {
			exec("/usr/bin/sudo /usr/local/bin/force_sync_manifests.sh", $output, $errorcode);
			if ($errorcode != 0) {
				$output = "<p>Error restarting Apache (code $errorcode)</p>";
			}
		}
		$this->render('syncmanifests', array('output' => $output));
	}

	/**
	 * Filters
	 */
	public function filters() {
		return array(
			'rights'
		);
	}

	public function actions() {
		return array(
			'page' => array(
				'class' => 'CViewAction',
				'layout' => 'page',
			),
		);
	}

	public function actionPuppetdb() {
		$this->render('application.views.site.puppetdb');
	}

	/**
	 * Main admin page
	 */
	public function actionIndex() {
		if (Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->createUrl('site/login'));
		}
		$this->redirect(Yii::app()->createUrl('site/home'));
	}

	public function actionSearch() {
		$q = null;
		$objlist = array();
		$numfound = 0;
		if (isset($_GET['q']) && ($_GET['q'] != '')) {
			$q = $_GET['q'];
			// Activate Solr
			spl_autoload_unregister(array('YiiBase', 'autoload'));
			require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'Solarium' . DIRECTORY_SEPARATOR . 'Autoloader.php');
			Solarium_Autoloader::register();
			/* TODO Move client configuration options to common.php */
			$solclient = new Solarium_Client(array('adapteroptions' => array('host' => 'localhost', 'port' => 8080, 'path' => '/solr/collection1/')));
			$ping = $solclient->createPing();
			$error = "";
			try {
				$solclient->ping($ping);
				$query = $solclient->createSelect();
				$query->setQuery($q);
				$query->setRows(10);
				$query->setStart(isset($_GET['page']) ? 10 * ($_GET['page'] - 1) : 0);
				$results = $solclient->select($query);
				$numfound = $results->getNumFound();
			} catch  (Solarium_Exception $e) {
				$error = $e->getMessage();
			}
			spl_autoload_register(array('YiiBase', 'autoload'));
			if ($error !== "") {
				Yii::app()->user->setFlash('error', "There was an error communicating with the search server: " . $error);
			} else {
				foreach ($results as $result) {
					$certname = $result['certname'];
					$model = Poste::model()->findByAttributes(array('nom_puppet' => $certname));
					$objlist[] = array('score' => $result['score'], 'model' => $model ? $model : ($certname . " (non reference dans Edupostes)"));
				}
			}
		}
		if (count($objlist) === 0) {
			Yii::app()->user->setFlash('error', "Votre recherche n'a renvoyee aucun resultat.");
		}
		$pages = new CPagination($numfound);
		$pages->pageSize = 10;
		$this->render('application.views.site.search', array('q' => $q, 'objlist' => $objlist, 'pages' => $pages));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				if (Yii::app()->user->isGuest) {
					$this->redirect(Yii::app()->createUrl('user/login'));
				} else {
					$this->render('application.views.site.error', $error);
				}
			}
		}
	}

	protected function lastVisit() {
		$lastVisit = User::model()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

	/**
	 * Displays the search options page
	 */
	public function actionSearchOptions() {
		$total = 0;
		if (Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->createUrl('user/login'));
		}
		$model = new SearchOptionsForm;
		if (isset($_POST['yt1']) && ($_POST['yt1'] === "Reindex search database")) {
			$creq = "http://localhost:8080/solr/collection1/dataimport?command=reload-config";
			$csess = curl_init($creq);
			curl_setopt($csess, CURLOPT_HEADER, true);
			curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
			$cres = curl_exec($csess);
			curl_close($csess);
			if (preg_match('/HTTP\/1.1 200 OK/', $cres)) {
				$creq = "http://localhost:8080/solr/collection1/dataimport?command=full-import";
				$csess = curl_init($creq);
				curl_setopt($csess, CURLOPT_HEADER, true);
				curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
				$cres = curl_exec($csess);
				curl_close($csess);
				if (preg_match('/HTTP\/1.1 200 OK/', $cres)) {
					Yii::app()->user->setFlash('success', "Successfully reindexed search data");
				} else {
					Yii::app()->user->setFlash('error', "Error reindexing search data");
				}
			} else {
				yiilog($cres);
				Yii::app()->user->setFlash('error', "Error reloading Solr configuration");
			}
		} elseif(isset($_POST['SearchOptionsForm'])) {
			$model->attributes = $_POST['SearchOptionsForm'];
			if ($model->validate()) {
				Yii::app()->config->set('searchoptions_defaultnblines', $model->defaultnblines);
				Yii::app()->user->setFlash('success', "Vos options ont été sauvegardées");
				$this->refresh();
			}
		}
		$model->defaultnblines = Yii::app()->config->get('searchoptions_defaultnblines');
		$this->render('application.views.site.searchoptions', array('model' => $model));
	}

	/**
	 * Displays the appearance options page
	 */
	public function actionAppearance() {
		if (Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->createUrl('user/login'));
		}
		$model = new AppearanceForm;
		if(isset($_POST['AppearanceForm'])) {
			$model->attributes = $_POST['AppearanceForm'];
			if ($model->validate()) {
				Yii::app()->config->set('appearance_logo', $model->logo);
				Yii::app()->config->set('appearance_favicon', $model->favicon);
				Yii::app()->config->set('appearance_uitheme', $model->uitheme);
				Yii::app()->user->setFlash('success', "Vos options ont été sauvegardées");
				$this->refresh();
			}
		}
		$model->logo = Yii::app()->config->get('appearance_logo');
		$model->favicon = Yii::app()->config->get('appearance_favicon');
		$model->uitheme = Yii::app()->config->get('appearance_uitheme');
		$this->render('application.views.site.appearance', array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
