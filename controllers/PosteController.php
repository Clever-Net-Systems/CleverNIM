<?php

class PosteController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.poste.admin';
	public $createview = 'application.views.poste.create';
	public $updateview = 'application.views.poste.update';
	public $taglistview = 'application.views.poste.taglist';

	public function allowedActions() {
		return 'ajoutPoste, getPoste, addPoste';
	}

	public $defaultAction = 'admin';

	public function filters() {
		return array(
			'adminNode + admin',
			'updateNode + update, updateEditable',
			'deleteNode + delete',
			'kickNode + kick',
			'VncNode + vnc',
		);
	}

	public function filterAdminNode($filterChain) {
		if (Yii::app()->user->checkAccess('Node.Admin') || Yii::app()->user->checkAccess('Node.AdminGroup')) {
			$filterChain->run();
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterUpdateNode($filterChain) {
		if (Yii::app()->user->checkAccess('Node.Update')) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("Node.UpdateGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			if (isset($_POST['pk'])) { // updateEditable request
				$id = $_POST['pk'];
			} elseif (isset($_GET['id'])) { // Normal update request
				$id = $_GET['id'];
			} else {
				throw new CHttpException(404, 'Unknown node.');
			}
			$model = $this->loadModel($id);
			if ($user->getPosteOK($model)) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterDeleteNode($filterChain) {
		if (Yii::app()->user->checkAccess('Node.Delete')) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("Node.DeleteGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$model = $this->loadModel($_GET['id']);
			if ($user->getPosteOK($model)) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterKickNode($filterChain) {
		if (Yii::app()->user->checkAccess('Node.Kick')) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("Node.KickGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$model = $this->loadModel($_GET['id']);
			if ($user->getPosteOK($model)) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function filterVncNode($filterChain) {
		if (Yii::app()->user->checkAccess('Node.Vnc')) {
			$filterChain->run();
		} elseif (Yii::app()->user->checkAccess("Node.VncGroup")) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$model = $this->loadModel($_GET['id']);
			if ($user->getPosteOK($model)) {
				$filterChain->run();
			} else {
				throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
			}
		} else {
			throw new CHttpException(403, Yii::t('app', 'You are not authorized to perform this action.'));
		}
	}

	public function loadModel($id) {
		$model = Poste::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Unknown node.');
		return $model;
	}

	public function actionUpdate($id) {
		$poste = Poste::model()->findByPk($_GET['id']);
		if ($poste === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Poste object.'));
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'poste-form') {
			echo CActiveForm::validate(array($poste));
			Yii::app()->end();
		}

		if (isset($_POST['Poste'])) {
			$poste->attributes = $_POST['Poste'];
			/* C'est pas dans la vue des postes qu'on modifie les tags */
			/*if (array_key_exists('tagsIds', $_POST['Poste'])) {
				$poste->tags = $poste->tagsIds;
			} else {
				$poste->tags = array();
			}*/
			if ($poste->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Poste object " . $poste->_intname . " successfully updated."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $poste->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Poste object " . $poste->_intname . "."));
			}
		}

		$poste->tagsIds = Yii::app()->db->createCommand("SELECT tags_id FROM poste_tags WHERE postes_id = :id")->queryColumn(array(":id" => $poste->id));
		$this->render($this->updateview, array(
			'poste' => $poste,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionCreate() {
		$poste = new Poste('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'poste-form') {
			echo CActiveForm::validate(array($poste));
			Yii::app()->end();
		}

		if (isset($_POST['Poste'])) {
			$poste->attributes = $_POST['Poste'];
			$poste->tags = $poste->tagsIds;
			$poste->creation = date("Y-m-d H:i:s");
			if ($poste->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', "Poste " . $poste->_intname . " successfully created."));
				$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin', 'id' => $poste->id));
			} else {
				Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Poste object " . $poste->_intname . "."));
			}
		}

		$this->render($this->createview, array(
			'poste' => $poste,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionKick() {
		$output = array();
		if (isset($_GET['id'])) {
			$poste = Poste::model()->findByPk($_GET['id']);
			if (!$poste) {
				throw new CHttpException(404, 'Poste inconnu: ' . $_GET['id']);
			}
			$ip = $poste->getFact('ipaddress_eth0');
			if (!$ip || ($ip == "")) {
				throw new CHttpException(404, 'Adresse IP inconnue pour le poste: ' . $_GET['id']);
			}
			$env = $poste->getFact('environnement');
			if (!$env || ($env == "")) {
				throw new CHttpException(404, 'Environnement inconnu pour le poste: ' . $_GET['id']);
			}
			if (isset($_POST['yt0']) && ($_POST['yt0'] == "Kicker") && isset($_POST['envaction']) && isset($_GET['id'])) {
				$errorcode = 0;
				switch ($_POST['envaction']) {
					case "nomodif": $env = ""; break;
					case "dev": $env = "dev"; break;
					case "valid": $env = "valid"; break;
					case "prod": $env = "production"; break;
				}
				exec("/usr/local/bin/kicker.sh $ip $env", $output, $errorcode);
				if ($errorcode != 0) {
					$output = array("Erreur de kick (code $errorcode)");
				}
			}
			$this->render('kick', array('output' => $output, 'poste' => $poste, 'env' => $env));
		} else {
			throw new CHttpException(500, 'Invalid request');
		}
	}

	public function actionVnc() {
		if (isset($_GET['id'])) {
			$poste = Poste::model()->findByPk($_GET['id']);
			if (!$poste) {
				throw new CHttpException(404, 'Poste inconnu: ' . $_GET['id']);
			}
			$ip = $poste->getFact('ipaddress_eth0');
			if ($ip && ($ip !== "")) {
				$this->render('vnc', array('ip' => $ip, 'erreur' => false));
			} else {
				$this->render('vnc', array('ip' => "", 'erreur' => true));
			}
		} else {
			header('HTTP/1.0 500 Invalid Request');
		}
	}

	/*
	 * Permet de savoir si un poste existe
	 * Nécessite le numéro de série en paramètre
	 * Exemple: wget -q -O- --header="X-Requested-With: XMLHttpRequest" --post-data "serial=13165D15-A8E2-4B4C-AC93-2C55DC27DC82" http://edupostes/poste/getPoste
	*/
	public function actionGetPoste() {
		$this->layout = false;
		/* Il faut que la requête soit Ajax, POST et que serial soit défini */
		if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest && isset($_POST['serial'])) {
			$poste = Poste::model()->findByAttributes(array('numero_de_serie' => $_POST['serial']));
			if ($poste) {
				echo CJSON::encode(array('id' => $poste->id, 'serial' => $poste->numero_de_serie, 'puppet' => $poste->nom_puppet, 'nom' => $poste->hostname));
			} else {
				echo CJSON::encode(array('erreur' => "Numero de serie non trouve"));
			}
		} else {
			header('HTTP/1.0 500 Invalid Request');
		}
	}

	private function checkName($nom, $routeur) {
		if ($nom == "") {
			return "Le nom du poste est vide";
		}
		if (strlen($nom) > 15) {
			return "Le nom du poste doit contenir au plus 15 caractères (il en contient " . strlen($nom) . " )";
		}
		$invalidchars = preg_replace(array('/[0-9]/', '/[A-Z]/', '/[a-z]/', '/-/'), '', $nom);
		if (strlen($invalidchars) > 0) {
			return "Le nom du poste ne doit contenir que des caracteres alphanumeriques et le tiret (il contient $invalidchars)";
		}
		if (!preg_match('/^[[:alnum:]]+-[[:alnum:]]+-[[:alnum:]]+$/', $nom)) {
			return "Le format entre n'est pas valide (il doit etre entre sous la forme NOMSITE-CLASSE-MACHINE)";
		}
		$listesites = file_get_contents("/etc/puppet/liste-sites.txt");
		if ($listesites === false) {
			return "Impossible de verifier le nom car impossible d'ouvrir /etc/puppet/liste-sites.txt";
		}
		// On crée une version tableau du liste-sites.txt
		$listesites = explode("\n", $listesites);
		foreach ($listesites as $site) {
			if ($site !== "") { // Pour éviter la dernière ligne vide
				$sites[] = explode(";", $site);
			}
		}
		// Check pour déterminer si le site existe, si le réseau est un réseau de test et si le nom est un nom valable parmi toute la liste
		$nomparts = explode('-', $nom);
		$ecole = $nomparts[0];
		$part3 = $nomparts[2];
		$siteok = false;
		$reseautest = false;
		$nomvalable = false;
		foreach ($sites as $site) {
			if (($site[0] == $routeur) && ($site[4] == $ecole)) {
				$siteok = true;
				$categorie = $site[1];
			}
			if (($site[0] == $routeur) && ($site[1] == "00")) {
				$reseautest = true;
				$categorie = $site[1];
			}
			if ($site[4] == $ecole) {
				$nomvalable = true;
				$categorie = $site[1];
			}
		}
		// Si l'école ne correspond pas au routeur et que ce n'est pas un réseau de test ou que c'est un réseau de test mais que le nom est pas valable
		if (!$siteok) {
			if (!$reseautest) {
				return "Ce nom de site " . $ecole . " n'est pas autorise sur ce reseau";
			} elseif (!$nomvalable) {
				return "Ce nom de site " . $ecole . " ne fait pas partie de la liste des noms autorises";
			}
		}
		// Check de la validité de la troisième partie du nom
		if (($categorie == "10") && (strlen($part3) != 6)) {
			return "La 3eme partie doit comporter 6 chiffres (mais elle en contient : " . strlen($part3) . " )";
		}
		$invalidchars = preg_replace(array('/[0-9]/'), '', $part3);
		if (($categorie == "10") && (strlen($invalidchars) > 0)) {
			return "La 3eme partie doit comporter uniquement des chiffres (mais elle contient : " . $invalidchars . " )";
		}
		return ""; // Tout bon
	}

	/*
	 * Crée ou modifie un poste
	 * Nécessite l'école en paramètre
	 * Exemple: wget -q -O- --header="X-Requested-With: XMLHttpRequest" --post-data "serial=13165D15-A8E2-4B4C-AC93-2C55DC27DC82&puppet=semtest-c-4646-201308261337.ceti.etat-ge.ch&nom=SEMTEST-C-4646&routeur=192.168.1.1" http://edupostes/poste/addPoste
	*/
	public function actionAddPoste() {
		header('Content-type: application/json; charset=UTF-8'); /* TODO fonctionne pas */
		$this->layout = false;
		/* Il faut que la requête soit Ajax, POST et que nom, serial, routeur et puppet (éventuellement vide) soient définis */
		if (Yii::app()->request->isPostRequest &&
			isset($_POST['nom']) &&
			isset($_POST['serial']) &&
			isset($_POST['routeur']) &&
			isset($_POST['puppet']) &&
			($_POST['routeur'] != "") &&
			($_POST['serial'] != "") &&
			($_POST['serial'] != "INCONNU")) {
			/* On vérifie la validité du nom du poste TODO Vérifier pourquoi c'est toujours là, on avait fait des validators */
			/*$erreur = $this->checkName($_POST['nom'], $_POST['routeur']);
			if ($erreur !== "") {
				//echo CJSON::encode(CJSON::unicodeToUTF8(array('erreur' => $erreur)));
				echo CJSON::encode(array('erreur' => $erreur));
				return;
			}*/
			/* On a un numéro de série, on check si on a une machine correspondante */
			$poste = Poste::model()->findByAttributes(array('numero_de_serie' => $_POST['serial']));
			if (!$poste) { /* Le poste n'existe pas, on le crée */
				$poste = new Poste();
				$poste->creation = date("Y-m-d H:i:s");
			}
			/* On update les propriétés du poste */
			$poste->hostname = $_POST['nom'];
			$poste->nom_puppet = $_POST['puppet'];
			$poste->numero_de_serie = $_POST['serial'];
			$poste->routeur = $_POST['routeur'];
			$poste->contact = date("Y-m-d H:i:s");
			/* On sauvegarde le poste */
			if ($poste->save()) {
				echo CJSON::encode(array('id' => $poste->id, 'serial' => $poste->numero_de_serie, 'puppet' => $poste->nom_puppet, 'nom' => $poste->hostname));
			} else {
				echo CJSON::encode(array('erreur' => "Impossible de sauvegarder le poste: " . mergeErrors($poste->getErrors())));
			}
		} else {
			header('HTTP/1.0 500 Invalid Request');
		}
	}

	/*
	 * Appelé par /etc/sem/register_edupostes
	 * On cherche d'abord un poste avec le même numéro de série (la clé unique officielle)
	 * Si on trouve le serial, on met à jour le nom, l'école et le nom Puppet
	 * Si on trouve pas le serial, on cherche le nom et l'école pour voir si le poste a pas été créé dans l'interface Web avant installation
	 * Si on trouve pas non plus le nom et l'école, on crée un nouveau poste
	*/
	public function actionAjoutPoste() {
		$this->layout = false;
		/* Il faut que la requête soit Ajax, POST et que nom, serial et puppet soient définis (éventuellement vides) */
		if (Yii::app()->request->isAjaxRequest &&
			Yii::app()->request->isPostRequest &&
			isset($_POST['nom']) &&
			isset($_POST['puppet']) &&
			isset($_POST['routeur']) &&
			isset($_POST['serial'])) {
			if (($_POST['serial'] !== "") && ($_POST['serial'] !== "INCONNU")) {
				/* On a un numéro de série, on check si on a une machine correspondante */
				$poste = Poste::model()->findByAttributes(array('numero_de_serie' => $_POST['serial']));
				if ($poste) {
					$poste->hostname = $_POST['nom'];
					$poste->nom_puppet = $_POST['puppet'];
					$poste->numero_de_serie = $_POST['serial'];
					$poste->routeur = $_POST['routeur'];
				} else { /* Le poste n'existe pas, on le crée */
					$poste = new Poste();
					$poste->hostname = $_POST['nom'];
					$poste->nom_puppet = $_POST['puppet'];
					$poste->numero_de_serie = $_POST['serial'];
					$poste->routeur = $_POST['routeur'];
				}
				if ($poste->save()) {
					echo CJSON::encode(array('id' => $poste->id, 'serial' => $poste->numero_de_serie, 'puppet' => $poste->nom_puppet, 'nom' => $poste->hostname));
				} else {
					throw new CHttpException(500, 'Erreur lors de la mise à jour du poste: ' . mergeErrors($poste->getErrors()));
				}
			} else {
				/* On vérifie si le poste a déjà été provisionné */
				$poste = Poste::model()->findByAttributes(array('hostname' => $_POST['nom']));
				if ($poste) { /* On a trouvé le poste, il suffit de mettre à jour les propriétés */
					$poste->nom_puppet = $_POST['puppet'];
					$poste->numero_de_serie = $_POST['serial'];
				} else { /* Le poste n'existe pas, on le crée */
					$poste = new Poste();
					$poste->hostname = $_POST['nom'];
					$poste->nom_puppet = $_POST['puppet'];
					$poste->numero_de_serie = $_POST['serial'];
					$poste->routeur = $_POST['routeur'];
				}
				if ($poste->save()) {
					echo CJSON::encode(array('id' => $poste->id, 'serial' => $poste->numero_de_serie, 'puppet' => $poste->nom_puppet, 'nom' => $poste->hostname));
				} else {
					throw new CHttpException(500, 'Erreur lors de la création / mise à jour du poste: ' . mergeErrors($poste->getErrors()));
				}
			}
		} else {
			throw new CHttpException(500, 'Requête invalide');
		}
	}

	public function renderTagList($id) {
		$poste = Poste::model()->findByPk($id);
		$this->renderPartial($this->taglistview, array(
			'poste' => $model,
		));
	}

	public function actionExport() {
		$model = new Poste('search');
		$columns = Yii::app()->puppetdb->createCommand("SELECT DISTINCT name FROM certname_facts")->queryAll();
		$csv = "OS,Hostname,Routeur,Certificat Puppet,Numero de serie,Date de creation,Date de dernier contact,";
		foreach ($columns as $column) {
			$factname = $column['name'];
			if (in_array($factname, explode(',', Yii::app()->user->getState('extraCols')))) {
				$csv .= $factname . ',';
			}
		}
		$csv .= "Tags\n";
		$dp = $model->search();
		$dp->setPagination(false);
		foreach($dp->getData() as $record) {
			$csv .= $record->getFact('operatingsystem') . ',';
			$csv .= $record->hostname . ',';
			$csv .= $record->routeur . ',';
			$csv .= $record->nom_puppet . ',';
			$csv .= $record->numero_de_serie . ',';
			$csv .= $record->creation . ',';
			$csv .= $record->contact . ',';
			foreach ($columns as $column) {
				$factname = $column['name'];
				if (in_array($factname, explode(',', Yii::app()->user->getState('extraCols')))) {
					$csv .= $record->getFact($factname) . ',';
				}
			}
			$csv .= implode(';', array_map(function ($p) { return $p->_intname; }, $record->tags)) . ',';
			$csv .= "\n";
		}
		foreach (Yii::app()->log->routes as $route) { /* Disable rendering of yiidebugtb inside CSV file */
			if ($route instanceof XWebDebugRouter) {
				$route->enabled = false;
			}
		}
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename=Poste_' . date('YmdHis') . '.csv');
		header('Cache-Control: max-age=0');
		echo $csv;
		Yii::app()->end();
	}

	public function actionAdmin() {
		$model = new Poste('search');
		$newposte = new Poste('create');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['addCol'])) {
			$cols = explode(',', Yii::app()->user->getState('extraCols'));
			$cols[] = $_GET['addCol'];
			$cols = array_unique($cols);
			Yii::app()->user->setState('extraCols', implode(',', $cols));
			unset($_GET['addCol']);
		}
		if (isset($_GET['delCol'])) {
			$cols = explode(',', Yii::app()->user->getState('extraCols'));
			$cols = array_unique($cols);
			if (($key = array_search($_GET['delCol'], $cols)) !== false) {
				unset($cols[$key]);
			}
			Yii::app()->user->setState('extraCols', implode(',', $cols));
			unset($_GET['delCol']);
		}
		if (isset($_GET['Poste']))
			$model->attributes = $_GET['Poste'];

		$this->render($this->adminview, array(
			'poste' => $model,
			'newposte' => $newposte,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
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
