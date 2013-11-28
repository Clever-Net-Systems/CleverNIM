<?php

class BiController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = "application.views.layouts.bootstrap";

	/**
	 * ETL for OLAP analysis
	 */
	public function actionGenerate() {
		$output = "";
		if (isset($_POST['yt0']) && ($_POST['yt0'] == "Generation")) {
			/* Nettoyage de toutes les tables */
			Yii::app()->db->createCommand()->delete('dwh_f_node');
			Yii::app()->db->createCommand()->delete('dwh_d_host');
			Yii::app()->db->createCommand()->delete('dwh_d_routeur');
			Yii::app()->db->createCommand()->delete('dwh_d_bios_vendor');
			Yii::app()->db->createCommand()->delete('dwh_d_bios_release_date');
			Yii::app()->db->createCommand()->delete('dwh_d_bios_version');
			Yii::app()->db->createCommand()->delete('dwh_d_ifspeed_eth0');
			Yii::app()->db->createCommand()->delete('dwh_d_manufacturer_screen1');
			Yii::app()->db->createCommand()->delete('dwh_d_env');
			Yii::app()->db->createCommand()->delete('dwh_d_osfamily');
			Yii::app()->db->createCommand()->delete('dwh_d_screens');
			Yii::app()->db->createCommand()->delete('dwh_d_regroupement');
			Yii::app()->db->createCommand()->delete('dwh_d_semconfigversions');
			Yii::app()->db->createCommand()->delete('dwh_d_product');
			/* Generation des dimensions */
			$hosts = Yii::app()->puppetdb->createCommand("SELECT name FROM certnames;")->queryColumn();
			foreach ($hosts as $host) {
				Yii::app()->db->createCommand()->insert('dwh_d_host', array(
							'certname' => $host,
							));
			}
			/* Add ecole to host */
			$ecoles = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name='ecole';")->queryAll();
			foreach ($ecoles as $ecole) {
				Yii::app()->db->createCommand("UPDATE dwh_d_host SET ecole = '" . $ecole['value'] . "' WHERE certname = '" . $ecole['certname'] . "'")->execute();
			}
			/* Add typeecole to host */
			$typeecoles = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name='typeecole';")->queryAll();
			foreach ($typeecoles as $typeecole) {
				Yii::app()->db->createCommand("UPDATE dwh_d_host SET typeecole = '" . $typeecole['value'] . "' WHERE certname = '" . $typeecole['certname'] . "'")->execute();
			}
			/* Add ipaddress_eth0 to host */
			$ipaddress_eth0s = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name='ipaddress_eth0';")->queryAll();
			foreach ($ipaddress_eth0s as $ipaddress_eth0) {
				Yii::app()->db->createCommand("UPDATE dwh_d_host SET ipaddress_eth0 = '" . $ipaddress_eth0['value'] . "' WHERE certname = '" . $ipaddress_eth0['certname'] . "'")->execute();
			}
			/* Routeur dimensions */
			$routeurs = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'routeur';")->queryColumn();
			foreach ($routeurs as $routeur) {
				Yii::app()->db->createCommand()->insert('dwh_d_routeur', array(
							'routeur' => $routeur,
							));
			}
			/* BIOS dimensions */
			$bios_vendors = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'bios_vendor';")->queryColumn();
			foreach ($bios_vendors as $bios_vendor) {
				Yii::app()->db->createCommand()->insert('dwh_d_bios_vendor', array(
							'vendor' => $bios_vendor,
							));
			}
			$bios_release_dates = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'bios_release_date';")->queryColumn();
			foreach ($bios_release_dates as $bios_release_date) {
				Yii::app()->db->createCommand("INSERT INTO dwh_d_bios_release_date (release_date) VALUES (STR_TO_DATE('" . $bios_release_date . "', '%m/%d/%Y'));")->execute();
			}
			$bios_versions = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'bios_version';")->queryColumn();
			foreach ($bios_versions as $bios_version) {
				Yii::app()->db->createCommand()->insert('dwh_d_bios_version', array(
							'version' => $bios_version,
							));
			}
			$ifspeed_eth0s = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'ifspeed_eth0';")->queryColumn();
			foreach ($ifspeed_eth0s as $ifspeed_eth0) {
				Yii::app()->db->createCommand()->insert('dwh_d_ifspeed_eth0', array(
							'speed' => $ifspeed_eth0,
							));
			}
			$manufacturer_screen1s = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'manufacturer_screen1';")->queryColumn();
			foreach ($manufacturer_screen1s as $manufacturer_screen1) {
				Yii::app()->db->createCommand()->insert('dwh_d_manufacturer_screen1', array(
							'manufacturer' => $manufacturer_screen1,
							));
			}
			$envs = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'environnement';")->queryColumn();
			foreach ($envs as $env) {
				Yii::app()->db->createCommand()->insert('dwh_d_env', array(
							'env' => $env,
							));
			}
			$osfamilys = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'osfamily';")->queryColumn();
			foreach ($osfamilys as $osfamily) {
				Yii::app()->db->createCommand()->insert('dwh_d_osfamily', array(
							'osfamily' => $osfamily,
							));
			}
			$screenss = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'screens';")->queryColumn();
			foreach ($screenss as $screens) {
				Yii::app()->db->createCommand()->insert('dwh_d_screens', array(
							'screens' => $screens,
							));
			}
			$regroupements = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'regroupement';")->queryColumn();
			foreach ($regroupements as $regroupement) {
				Yii::app()->db->createCommand()->insert('dwh_d_regroupement', array(
							'regroupement' => $regroupement,
							));
			}
			/* Dimension des versions SEM */
			$semconfigversions = Yii::app()->puppetdb->createCommand("SELECT DISTINCT (array_agg(value))[1] AS type, (array_agg(value))[2] AS majeure, (array_agg(value))[3] AS mineure FROM (SELECT certname, name, value FROM certname_facts WHERE name = 'semconfigversionmajeure' OR name = 'semconfigversionmineure' OR name = 'semconfigtype' ORDER BY certname, name) AS cf GROUP BY certname;")->queryAll();
			foreach ($semconfigversions as $semconfigversion) {
				Yii::app()->db->createCommand()->insert('dwh_d_semconfigversions', array(
							'type' => $semconfigversion['type'],
							'majeure' => $semconfigversion['majeure'],
							'mineure' => $semconfigversion['mineure'],
							));
			}
			/* Dimension product */
			$products = Yii::app()->puppetdb->createCommand("SELECT DISTINCT (array_agg(value))[1] AS manufacturer, (array_agg(value))[3] AS type, (array_agg(value))[2] AS name FROM (SELECT certname, name, value FROM certname_facts WHERE name = 'manufacturer' OR name = 'type' OR name = 'productname' ORDER BY certname, name) AS cf GROUP BY certname;")->queryAll();
			foreach ($products as $product) {
				Yii::app()->db->createCommand()->insert('dwh_d_product', array(
							'manufacturer' => $product['manufacturer'] ? $product['manufacturer'] : "Unknown",
							'type' => $product['type'] ? $product['type'] : "Unknown",
							'name' => $product['name'] ? $product['name'] : "Unknown",
							));
			}
			$nopostecount = 0;
			$postecount = 0;
			$errcount = 0;
			$hosts = Yii::app()->puppetdb->createCommand("SELECT DISTINCT certname FROM certname_facts")->queryColumn();
			foreach ($hosts as $host) {
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $host . "'")->queryScalar();
				Yii::app()->db->createCommand("INSERT INTO dwh_f_node (host_id) VALUES (" . $id . ")")->execute();
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'routeur'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_routeur WHERE routeur = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET routeur_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'bios_release_date'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_bios_release_date WHERE release_date = STR_TO_DATE('" . $fact['value'] . "', '%m/%d/%Y');")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET bios_release_date_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'bios_vendor'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_bios_vendor WHERE vendor = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET bios_vendor_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'bios_version'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_bios_version WHERE version = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET bios_version_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'ifspeed_eth0'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_ifspeed_eth0 WHERE speed = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET ifspeed_eth0_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'manufacturer_screen1'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_manufacturer_screen1 WHERE manufacturer = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET manufacturer_screen1_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'environnement'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_env WHERE env = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET env_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'osfamily'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_osfamily WHERE osfamily = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET osfamily_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'screens'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_screens WHERE screens = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET screens_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'regroupement'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_regroupement WHERE regroupement = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET regroupement_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			/* Versions SEM */
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, (array_agg(value))[1] AS type, (array_agg(value))[2] AS majeure, (array_agg(value))[3] AS mineure FROM (SELECT certname, name, value FROM certname_facts WHERE name = 'semconfigversionmajeure' OR name = 'semconfigversionmineure' OR name = 'semconfigtype' ORDER BY certname, name) AS cf GROUP BY certname;")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_semconfigversions WHERE type = '" . $fact['type'] . "' AND majeure = '" . $fact['majeure'] . "' AND mineure = '" . $fact['mineure'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET semconfigversions_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			/* Versions SEM */
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, (array_agg(value))[1] AS type, (array_agg(value))[2] AS majeure, (array_agg(value))[3] AS mineure FROM (SELECT certname, name, value FROM certname_facts WHERE name = 'semconfigversionmajeure' OR name = 'semconfigversionmineure' OR name = 'semconfigtype' ORDER BY certname, name) AS cf GROUP BY certname;")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_semconfigversions WHERE type = '" . $fact['type'] . "' AND majeure = '" . $fact['majeure'] . "' AND mineure = '" . $fact['mineure'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET semconfigversions_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			/* Product */
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, (array_agg(value))[1] AS manufacturer, (array_agg(value))[3] AS type, (array_agg(value))[2] AS name FROM (SELECT certname, name, value FROM certname_facts WHERE name = 'manufacturer' OR name = 'type' OR name = 'productname' ORDER BY certname, name) AS cf GROUP BY certname;")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$manufacturer = $fact['manufacturer'] ? $fact['manufacturer'] : "Unknown";
				$type = $fact['type'] ? $fact['type'] : "Unknown";
				$name = $fact['name'] ? $fact['name'] : "Unknown";
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_product WHERE manufacturer = '" . $manufacturer . "' AND type = '" . $type . "' AND name = '" . $name . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET product_id = " . $id . " WHERE host_id = " . $hid)->execute();
				}
			}
			/* Memory measure */
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'memorysize'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				if ($hid) {
					$mem = preg_match('/^([-+]?[0-9]*\.?[0-9]+) (GB|MB|KB)$/', $fact['value'], $matches);
					if ($mem === 1) {
						if ($matches[2] === "GB") { $mem = $matches[1] * 1024 * 1024; }
						if ($matches[2] === "MB") { $mem = $matches[1] * 1024; }
						Yii::app()->db->createCommand("UPDATE dwh_f_node SET memorysize = " . $mem . " WHERE host_id = " . $hid)->execute();
					}
				}
			}
			/* Uptime measure */
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'uptime'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				if ($hid) {
					$uptime = preg_match('/^([0-9]+):([0-9]+) hours$/', $fact['value'], $matches);
					if ($uptime === 1) {
						$uptime = $matches[1] * 60 + $matches[2];
						Yii::app()->db->createCommand("UPDATE dwh_f_node SET uptime = " . $uptime . " WHERE host_id = " . $hid)->execute();
					}
				}
			}
		}
		$this->render('generate', array('output' => $output));
	}

	/**
	 * Filters
	 */
	public function filters() {
		return array(
			'rights'
		);
	}

	/**
	 * @var string the default controller action
	 */
	public $defaultAction = 'olap';

	/**
	 * This is the default 'main' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionOlap() {
		$this->render('application.views.bi.olap');
	}
}
