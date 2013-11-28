<?php

class TagController extends Controller {
	public $adminview = 'application.views.tag.admin';
	public $createview = 'application.views.tag.create';
	public $updateview = 'application.views.tag.update';
	public $codaview = 'application.views.tag.coda';
	public $layout = "application.views.layouts.bootstrap";
	public $mergeview = 'application.views.tag.merge';
	public $exportview = 'application.views.tag.export';

	public function allowedActions() {
		return 'ENC';
	}

	/* We can't use yaml_emit() here because we need to be able to have multiple classes with the same name and a PHP associative array will not allow that */
	/* TODO Faire en sorte que Puppet appelle le script de nettoyage des imprimantes apres un run, histoire de supprimer les imprimantes qui n'apparaissent plus */
	public function actionENC() {
		$this->layout = false;
		/* Il faut que la requête soit Ajax, POST et que nom, serial et puppet soient définis (éventuellement vides) */
		if (Yii::app()->request->isPostRequest && isset($_POST['certname'])) {
			// yaml_emit() fonctionne pas donc on y va manuellement
			//echo yaml_emit($yaml);
			echo "---\n";
			echo "parameters: ~\n";
			echo "environment: ~\n";
			echo "classes:\n";
			/* Check si le poste existe */
			$poste = Poste::model()->findByAttributes(array('nom_puppet' => $_POST['certname']));
			if (!$poste) {
				yiilog("Poste non trouve: " . $_POST['certname']);
				return;
			}
			/* Securite temporaire pendant deploiement */
			return;
			/* Récupération des facts du poste */
			$factsarray = $poste->getFacts();
			foreach ($factsarray as $elem) {
				$facts[$elem['name']] = $elem['value'];
			}
			/* Initialisation de l'arbre yaml */
			$yaml = array('parameters' => null, 'environment' => null, 'classes' => array());
//			/* On récupère les facts de cette machine et on sort direct si elle est pas référencée */
//			$creq = "https://educonfig.ceti.etat-ge.ch:8140/production/facts/" . $_POST['certname'];
//			$csess = curl_init($creq);
//			curl_setopt($csess, CURLOPT_HEADER, false);
//			curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
//			curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, 0);
//			curl_setopt($csess, CURLOPT_HTTPHEADER, array("Accept: yaml"));
//			$cres = curl_exec($csess);
//			curl_close($csess);
//			if (preg_match('/No specified acceptable formats/', $cres) ||
//				preg_match('/Could not find facts/', $cres) ||
//				preg_match('/No request key specified/', $cres)) {
//				return;
//			} else {
//				/* Parse YAML structure */
//				$facts = yaml_parse($cres);
//				$facts = $facts['values'];
//			}
			/* Sécurité pendant dev, on ne renvoie rien pour la production */
			if (isset($facts['environnement'])) {
				yiilog($facts['environnement']);
			} else {
				yiilog("Fact environnement indéfini");
			}
			if (isset($facts['environnement']) && (($facts['environnement'] == 'dev') || ($facts['environnement'] == 'valid'))) {
				/* Gestion des tags manuels */
				foreach($poste->tags as $tag) {
					if ($tag->groupement->check($facts)) {
						$ttag = array();
						//echo "  " . $tag->type_de_tag->classe . ":\n";
						foreach ($tag->valeurs as $valeurparam) {
							//echo "    " . $valeurparam->parametre->nom . ": " . $valeurparam->valeur . "\n";
							if ($valeurparam->parametre->type == 2) {
								$possibles = explode(',', $valeurparam->parametre->possibles);
								$ttag[$valeurparam->parametre->nom] = $possibles[$valeurparam->valeur];
							} else {
								$ttag[$valeurparam->parametre->nom] = $valeurparam->valeur;
							}
						}
						if ($tag->type_de_tag->classe === "imprimante") { /* Cas spécial d'une imprimante, on regroupe tout sous le tag imprimantes */
							$yaml['imprimantes'][$ttag['name']] = $ttag;
						} else {
							$yaml['classes'][$tag->type_de_tag->classe] = $ttag;
						}
					}
				}
				/* Gestion des tags automatiques */
				$tagautos = Tagauto::model()->findAll();
				foreach ($tagautos as $tagauto) {
					if ($tagauto->groupement->check($facts)) {
						$factok = true;
						$factnb = 0;
						foreach ($tagauto->faits as $fait) {
							if (!array_key_exists($fait->fact, $facts) || (!$fait->checkValue($facts[$fait->fact]))) {
								$factok = false;
							} else {
								$factnb++;
							}
						}
						if ($factok && ($factnb > 0)) {
							//echo "  " . $tagauto->classe . ":\n";
							$yaml['classes'][$tagauto->classe] = null;
						}
					}
				}
			}
			if (array_key_exists('classes', $yaml)) {
				foreach ($yaml['classes'] as $class => $vals) {
					echo "  " . $class . ":\n";
					if ($vals) {
						foreach ($vals as $name => $val) {
							echo "    " . $name . ": " . $val . "\n";
						}
					}
				}
			}
			/* On sort toujours la classe imprimantes même si elle est vide, histoire de purger /etc/sem/puppetprinters */
			echo "  imprimantes:\n";
			if (array_key_exists('imprimantes', $yaml)) {
				echo "    instances:\n";
				foreach ($yaml['imprimantes'] as $class => $vals) {
					if ($vals) {
						echo "      " . $vals['name'] . ":\n";
						foreach ($vals as $name => $val) {
							if ($name !== "name") {
								echo "        " . $name . ": " . $val . "\n";
							}
						}
					}
				}
			}
		} else {
			throw new CHttpException(500, 'Requête invalide');
		}
	}

	public function actionExport() {
		$model = new Tag('search');
		$csv = "Groupement,Postes,Type de tag,Valeurs\n";
		$dp = $model->search();
		$dp->setPagination(false);
		foreach($dp->getData() as $record) {
			$csv .= $record->groupement->_intname . ',';
			$csv .= implode(';', array_map(function ($p) { return $p->_intname; }, $record->postes)) . ',';
			$csv .= $record->type_de_tag->_intname . ',';
			$csv .= implode(';', array_map(function ($p) { return $p->_intname; }, $record->valeurs)) . ',';
			$csv .= "\n";
		}
		foreach (Yii::app()->log->routes as $route) { /* Disable rendering of yiidebugtb inside CSV file */
			if ($route instanceof XWebDebugRouter) {
				$route->enabled = false;
			}
		}
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename=Tag_' . date('YmdHis') . '.csv');
		header('Cache-Control: max-age=0');
		echo $csv;
		Yii::app()->end();
	}

	public function actionAdmin() {
		$model = new Tag('search');
		$newtag = new Tag('create');

		$paramvalues = array();
		foreach (Tagparam::model()->findAll() as $param) {
			$paramvalue = new Valeurparam();
			$paramvalue->parametre_id = $param->id;
			/* TODO Résoudre ce problème */
			$paramvalues[$param->id] = $paramvalue;
		}

		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		if (isset($_GET['Tag']))
			$model->attributes = $_GET['Tag'];

		$this->render($this->adminview, array(
			'tag' => $model,
			'newtag' => $newtag,
			'paramvalues' => $paramvalues,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionCreate() {
		$tag = new Tag('create');

		$paramvalues = array();
		foreach (Tagparam::model()->findAll() as $param) {
			$paramvalue = new Valeurparam();
			$paramvalue->parametre_id = $param->id;
			/* TODO Résoudre ce problème */
			$paramvalues[$param->id] = $paramvalue;
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'tag-form') {
		echo CActiveForm::validate(array($tag));
			Yii::app()->end();
		}

		if (isset($_POST['Tag'])) {
			$tag->attributes = $_POST['Tag'];
			$tag->postes = $tag->postesIds;
			$valid = true;
			$valid = $tag->validate() && $valid;
			if ($valid) {
				if ($valid && $tag->save(false)) {
					if (isset($_POST['Valeurparam'])) {
						foreach ($tag->type_de_tag->parametre as $param) {
							if (isset($_POST['Valeurparam'][$param->id]) && isset($_POST['Valeurparam'][$param->id]['valeur'])) {
								$paramvalues[$param->id]->valeur = $_POST['Valeurparam'][$param->id]['valeur'];
							} else {
								$paramvalues[$param->id]->valeur = "";
							}
							$paramvalues[$param->id]->tag_id = $tag->id;
							$paramvalues[$param->id]->parametre_id = $param->id;
							if (!$paramvalues[$param->id]->save()) {
								yiilog("Erreur dans l'update d'un Valeurparam: " . mergeErrors($paramvalues[$param->id]->getErrors()));
							}
						}
					}
					Yii::app()->user->setFlash('success', Yii::t('app', "Tag " . $tag->_intname . " successfully created."));
					$this->redirect(array('admin', 'id' => $tag->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error creating Tag object " . $tag->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$this->render($this->createview, array(
			'tag' => $tag,
			'paramvalues' => $paramvalues,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	/* TODO Si on change le type de tag, ça vire pas les valeurparam du type de tag précédent -> a mettre dans Jira */
	public function actionUpdate($id) {
		$tag = Tag::model()->findByPk($_GET['id']);
		if ($tag === null) {
			throw new CHttpException(404, Yii::t('app', 'Non-existant Tag object.'));
		}

		$paramvalues = array();
		foreach (Tagparam::model()->findAll() as $param) {
			$paramvalue = new Valeurparam();
			$paramvalue->parametre_id = $param->id;
			$paramvalues[$param->id] = $paramvalue;
		}

		// For those for which we have an assigned paramvalue, load it
		foreach ($tag->valeurs as $pv) {
			$paramvalues[$pv->parametre->id] = ValeurParam::model()->findByPk($pv->id);
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'tag-form') {
			echo CActiveForm::validate(array($tag));
			Yii::app()->end();
		}

		if (isset($_POST['Tag'])) {
			$tag->attributes = $_POST['Tag'];
			if (array_key_exists('postesIds', $_POST['Tag'])) {
				$tag->postes = $tag->postesIds;
			} else {
				$tag->postes = array();
			}
			$valid = true;
			$valid = $tag->validate() && $valid;
			if ($valid) {
				if ($valid && $tag->save(false)) {
					if (isset($_POST['Valeurparam'])) {
						foreach ($tag->type_de_tag->parametre as $param) {
							if (isset($_POST['Valeurparam'][$param->id]) && isset($_POST['Valeurparam'][$param->id]['valeur'])) {
								$paramvalues[$param->id]->valeur = $_POST['Valeurparam'][$param->id]['valeur'];
							} else {
								$paramvalues[$param->id]->valeur = "";
							}
							$paramvalues[$param->id]->tag_id = $tag->id;
							$paramvalues[$param->id]->parametre_id = $param->id;
							if (!$paramvalues[$param->id]->save()) {
								yiilog($paramvalues[$param->id]->tag_id);
								yiilog($paramvalues[$param->id]->parametre_id);
								yiilog($paramvalues[$param->id]->valeur);
								yiilog("Erreur dans l'update d'un Valeurparam: " . mergeErrors($paramvalues[$param->id]->getErrors()));
							}
						}
					}
					Yii::app()->user->setFlash('success', Yii::t('app', "Tag object " . $tag->_intname . " successfully updated."));
					$this->redirect(array('admin', 'id' => $tag->id));
				} else {
					Yii::app()->user->setFlash('error', Yii::t('app', "Error updating Tag object " . $tag->_intname . "."));
					$valid = false;
				}
				// TODO Delete previously created objects if not valid
			}
		}

		$tag->postesIds = Yii::app()->db->createCommand("SELECT postes_id FROM poste_tags WHERE tags_id = :id")->queryColumn(array(":id" => $tag->id));
		$this->render($this->updateview, array(
			'tag' => $tag,
			'paramvalues' => $paramvalues,
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
		$model = $this->loadModel($_GET['id'], 'Tag');
		if (isset($model->user_id) && Yii::app()->user->checkAccess('Tag.UpdateDeleteSelf', array('userid' => $model->user_id))) {
			$filterChain->removeAt(1);
		}
		$filterChain->run();
	}

	public $defaultAction = 'admin';

	public function actionCoda() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
			$model = Tag::model()->findByPk($_GET['id']);
			if ($model) {
				if (Yii::app()->user->checkAccess("Tag.CodaAll") || (Yii::app()->user->checkAccess("Tag.CodaSelf") && (Yii::app()->user->id == $model->user_id))) {
					$this->layout = false;
					$this->render($this->codaview, array(
						'tag' => $model,
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

	public function loadModel($id) {
		$model = Tag::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'Le tag demandé n\'existe pas.');
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
