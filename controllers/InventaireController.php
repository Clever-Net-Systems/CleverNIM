<?php

class InventaireController extends Controller {
	public $layout = "application.views.layouts.bootstrap";
	public $adminview = 'application.views.inventaire.admin';

	public function actionGrotest() {
		/* On nettoie d'abord la table avant de tout reimporter */
		//Yii::app()->db->createCommand()->delete('inventaire');
		$output = "";
		$nopostecount = 0;
		$postecount = 0;
		$softcount = 0;
		if (isset($_POST['yt0']) && ($_POST['yt0'] == "Generation")) {
			$facts = Yii::app()->puppetdb->createCommand("SELECT DISTINCT name FROM certname_facts")->queryAll();
			$output = array();
			$user = User::model()->findByPk(Yii::app()->user->id);
			foreach ($facts as $fact) {
				$output[] = $fact['name'];
			}
			//$output = array("$softcount logiciels sur $postecount postes ($nopostecount postes inconnus)");
		}
		$this->render('generate', array('output' => $output));
	}

	public function actionGenerate() {
		/* Increase max_execution_time */
		set_time_limit(3600); /* Max 1 hour */
		/* Disable index keys */
		Yii::app()->db->createCommand("ALTER TABLE `inventaire` DISABLE KEYS;")->execute();
		$output = "";
		$nopostecount = 0;
		$postecount = 0;
		$softcount = 0;
		if (isset($_POST['yt0']) && ($_POST['yt0'] == "Generation")) {
			/* On nettoie d'abord la table avant de tout reimporter */
			Yii::app()->db->createCommand()->delete('inventaire');
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'inventory'")->queryAll();
			$output = array();
			$user = User::model()->findByPk(Yii::app()->user->id);
			foreach ($facts as $fact) {
				$inventaire = explode(';', bzdecompress(base64_decode(substr($fact['value'], 27))));
				$poste = Poste::model()->findByAttributes(array('nom_puppet' => $fact['certname']));
				if ($poste) {
					foreach ($inventaire as $logiciel) {
						if ($logiciel !== "") {
							$nomversion = explode('#', $logiciel);
							Yii::app()->db->createCommand()->insert('inventaire', array(
										'_intname' => $fact['certname'] . " " . $nomversion[0] . " " . $nomversion[1],
										'software' => $nomversion[0],
										'version' => $nomversion[1],
										'host_id' => $poste->id,
										'user_id' => $user->id,
										));
							$softcount++;
						}
					}
					$postecount++;
				} else {
					$nopostecount++;
				}
			}
			$output = array("$softcount logiciels sur $postecount postes ($nopostecount postes inconnus)");
		}
		/* Enable index keys */
		Yii::app()->db->createCommand("ALTER TABLE `inventaire` ENABLE KEYS;")->execute();
		$this->render('generate', array('output' => $output));
	}

	public function actionExport() {
		$model = new Inventaire('search');
		$columns = Yii::app()->puppetdb->createCommand("SELECT DISTINCT name FROM certname_facts")->queryAll();
		$csv = "Hote,";
		foreach ($columns as $column) {
			$factname = $column['name'];
			if (in_array($factname, explode(',', Yii::app()->user->getState('extraCols')))) {
				$csv .= $factname . ',';
			}
		}
		$csv .= "Software,Version\n";
		$dp = $model->search();
		//$dp->setPagination(false); /* On veut pas tout, ca ferait bcp trop de lignes */
		foreach($dp->getData() as $record) {
			$csv .= $record->host->_intname . ',';
			foreach ($columns as $column) {
				$factname = $column['name'];
				if (in_array($factname, explode(',', Yii::app()->user->getState('extraCols')))) {
					$csv .= $record->host->getFact($factname) . ',';
				}
			}
			$csv .= $record->software . ',';
			$csv .= $record->version . ',';
			$csv .= "\n";
		}
		foreach (Yii::app()->log->routes as $route) { /* Disable rendering of yiidebugtb inside CSV file */
			if ($route instanceof XWebDebugRouter) {
				$route->enabled = false;
			}
		}
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename=Inventaire_' . date('YmdHis') . '.csv');
		header('Cache-Control: max-age=0');
		echo $csv;
		Yii::app()->end();
	}

	public function actionAdmin() {
		$model = new Inventaire('search');

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

		$this->render($this->adminview, array(
			'inventaire' => $model,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}
}
