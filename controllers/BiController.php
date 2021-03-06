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
			Yii::app()->db->createCommand()->delete('dwh_f_printer');
			Yii::app()->db->createCommand()->delete('dwh_f_node');
			Yii::app()->db->createCommand()->delete('dwh_d_host');
			Yii::app()->db->createCommand()->delete('dwh_d_router');
			Yii::app()->db->createCommand()->delete('dwh_d_bios_vendor');
			Yii::app()->db->createCommand()->delete('dwh_d_bios_release_date');
			Yii::app()->db->createCommand()->delete('dwh_d_bios_version');
			Yii::app()->db->createCommand()->delete('dwh_d_ifspeed_eth0');
			Yii::app()->db->createCommand()->delete('dwh_d_manufacturer_screen1');
			Yii::app()->db->createCommand()->delete('dwh_d_env');
			Yii::app()->db->createCommand()->delete('dwh_d_osfamily');
			Yii::app()->db->createCommand()->delete('dwh_d_regroupement');
			Yii::app()->db->createCommand()->delete('dwh_d_semconfigversions');
			Yii::app()->db->createCommand()->delete('dwh_d_product');
			/* Generation des dimensions */
			$hosts = Yii::app()->puppetdb->createCommand("SELECT name FROM certnames;")->queryColumn();
			foreach ($hosts as $host) {
				Yii::app()->db->createCommand()->insert('dwh_d_host', array('certname' => $host));
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
			Yii::app()->db->createCommand()->insert('dwh_d_router', array('router' => 'Unknown'));
			$routers = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'routeur';")->queryColumn();
			foreach ($routers as $router) {
				Yii::app()->db->createCommand()->insert('dwh_d_router', array('router' => $router));
			}
			/* BIOS dimensions */
			Yii::app()->db->createCommand()->insert('dwh_d_bios_vendor', array('vendor' => 'Unknown'));
			$bios_vendors = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'bios_vendor';")->queryColumn();
			foreach ($bios_vendors as $bios_vendor) {
				Yii::app()->db->createCommand()->insert('dwh_d_bios_vendor', array('vendor' => $bios_vendor));
			}
			Yii::app()->db->createCommand()->insert('dwh_d_bios_release_date', array('release_date' => '1970-01-01'));
			$bios_release_dates = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'bios_release_date';")->queryColumn();
			foreach ($bios_release_dates as $bios_release_date) {
				Yii::app()->db->createCommand("INSERT INTO dwh_d_bios_release_date (release_date) VALUES (STR_TO_DATE('" . $bios_release_date . "', '%m/%d/%Y'));")->execute();
			}
			Yii::app()->db->createCommand()->insert('dwh_d_bios_version', array('version' => 'Unknown'));
			$bios_versions = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'bios_version';")->queryColumn();
			foreach ($bios_versions as $bios_version) {
				Yii::app()->db->createCommand()->insert('dwh_d_bios_version', array('version' => $bios_version));
			}
			Yii::app()->db->createCommand()->insert('dwh_d_ifspeed_eth0', array('speed' => 'Unknown'));
			$ifspeed_eth0s = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'ifspeed_eth0';")->queryColumn();
			foreach ($ifspeed_eth0s as $ifspeed_eth0) {
				Yii::app()->db->createCommand()->insert('dwh_d_ifspeed_eth0', array('speed' => $ifspeed_eth0));
			}
			Yii::app()->db->createCommand()->insert('dwh_d_manufacturer_screen1', array('manufacturer' => 'Unknown'));
			$manufacturer_screen1s = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'manufacturer_screen1';")->queryColumn();
			foreach ($manufacturer_screen1s as $manufacturer_screen1) {
				Yii::app()->db->createCommand()->insert('dwh_d_manufacturer_screen1', array('manufacturer' => $manufacturer_screen1));
			}
			Yii::app()->db->createCommand()->insert('dwh_d_env', array('env' => 'Unknown'));
			$envs = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'environnement';")->queryColumn();
			foreach ($envs as $env) {
				Yii::app()->db->createCommand()->insert('dwh_d_env', array('env' => $env));
			}
			$osfamilys = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'osfamily';")->queryColumn();
			foreach ($osfamilys as $osfamily) {
				Yii::app()->db->createCommand()->insert('dwh_d_osfamily', array('osfamily' => $osfamily));
			}
			Yii::app()->db->createCommand()->insert('dwh_d_regroupement', array('regroupement' => 'Unknown'));
			$regroupements = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'regroupement';")->queryColumn();
			foreach ($regroupements as $regroupement) {
				Yii::app()->db->createCommand()->insert('dwh_d_regroupement', array('regroupement' => $regroupement));
			}
			/* Dimension des versions SEM */
			Yii::app()->db->createCommand()->insert('dwh_d_semconfigversions', array('type' => 'Unknown', 'majeure' => 'Unknown', 'mineure' => 'Unknown'));
			$semconfigversions = Yii::app()->puppetdb->createCommand("SELECT DISTINCT (array_agg(value))[1] AS type, (array_agg(value))[2] AS majeure, (array_agg(value))[3] AS mineure FROM (SELECT certname, name, value FROM certname_facts WHERE name = 'semconfigversionmajeure' OR name = 'semconfigversionmineure' OR name = 'semconfigtype' ORDER BY certname, name) AS cf GROUP BY certname;")->queryAll();
			foreach ($semconfigversions as $semconfigversion) {
				Yii::app()->db->createCommand()->insert('dwh_d_semconfigversions', array(
							'type' => $semconfigversion['type'],
							'majeure' => $semconfigversion['majeure'],
							'mineure' => $semconfigversion['mineure'],
							));
			}
			/* Dimension product */
			Yii::app()->db->createCommand()->insert('dwh_d_product', array('manufacturer' => 'Unknown', 'type' => 'Unknown', 'name' => 'Unknown'));
			$products = Yii::app()->puppetdb->createCommand("SELECT DISTINCT (array_agg(value))[1] AS manufacturer, (array_agg(value))[3] AS type, (array_agg(value))[2] AS name FROM (SELECT certname, name, value FROM certname_facts WHERE name = 'manufacturer' OR name = 'type' OR name = 'productname' ORDER BY certname, name) AS cf GROUP BY certname;")->queryAll();
			foreach ($products as $product) {
				Yii::app()->db->createCommand()->insert('dwh_d_product', array(
							'manufacturer' => $product['manufacturer'] ? $product['manufacturer'] : "Unknown",
							'type' => $product['type'] ? $product['type'] : "Unknown",
							'name' => $product['name'] ? $product['name'] : "Unknown",
							));
			}
			/* FACTS */
			$nopostecount = 0;
			$postecount = 0;
			$errcount = 0;
			$hosts = Yii::app()->puppetdb->createCommand("SELECT DISTINCT certname FROM certname_facts")->queryColumn();
			foreach ($hosts as $host) {
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $host . "'")->queryScalar();
				Yii::app()->db->createCommand("INSERT INTO dwh_f_node (host_id) VALUES (" . $id . ")")->execute();
			}
			/* Default unknown values */
			$unknownscreen1manufacturer = Yii::app()->db->createCommand("SELECT id FROM dwh_d_manufacturer_screen1 WHERE manufacturer = 'Unknown';")->queryScalar();
			$unknownrouter = Yii::app()->db->createCommand("SELECT id FROM dwh_d_router WHERE router = 'Unknown';")->queryScalar();
			$unknownbiosvendor = Yii::app()->db->createCommand("SELECT id FROM dwh_d_bios_vendor WHERE vendor = 'Unknown';")->queryScalar();
			$unknownbiosreleasedate = Yii::app()->db->createCommand("SELECT id FROM dwh_d_bios_release_date WHERE release_date = '1970-01-01';")->queryScalar();
			$unknownbiosversion = Yii::app()->db->createCommand("SELECT id FROM dwh_d_bios_version WHERE version = 'Unknown';")->queryScalar();
			$unknownifspeed = Yii::app()->db->createCommand("SELECT id FROM dwh_d_ifspeed_eth0 WHERE speed = 'Unknown';")->queryScalar();
			$unknownenv = Yii::app()->db->createCommand("SELECT id FROM dwh_d_env WHERE env = 'Unknown';")->queryScalar();
			$unknownregroupement = Yii::app()->db->createCommand("SELECT id FROM dwh_d_regroupement WHERE regroupement = 'Unknown';")->queryScalar();
			$unknownsemconfigversions = Yii::app()->db->createCommand("SELECT id FROM dwh_d_semconfigversions WHERE type = 'Unknown' AND majeure = 'Unknown' AND mineure = 'Unknown';")->queryScalar();
			$unknownproduct = Yii::app()->db->createCommand("SELECT id FROM dwh_d_product WHERE manufacturer = 'Unknown' AND type = 'Unknown' AND name = 'Unknown';")->queryScalar();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET manufacturer_screen1_id = " . $unknownscreen1manufacturer)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET router_id = " . $unknownrouter)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET bios_vendor_id = " . $unknownbiosvendor)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET bios_release_date_id = " . $unknownbiosreleasedate)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET bios_version_id = " . $unknownbiosversion)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET ifspeed_eth0_id = " . $unknownifspeed)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET env_id = " . $unknownenv)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET regroupement_id = " . $unknownregroupement)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET semconfigversions_id = " . $unknownsemconfigversions)->execute();
			Yii::app()->db->createCommand("UPDATE dwh_f_node SET product_id = " . $unknownproduct)->execute();
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, value FROM certname_facts WHERE name = 'routeur'")->queryAll();
			foreach ($facts as $fact) {
				$hid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_router WHERE router = '" . $fact['value'] . "';")->queryScalar();
				if ($hid && $id) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET router_id = " . $id . " WHERE host_id = " . $hid)->execute();
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
				if ($hid) {
					Yii::app()->db->createCommand("UPDATE dwh_f_node SET screens = " . $fact['value'] . " WHERE host_id = " . $hid)->execute();
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
			/* Printer Cube */
			Yii::app()->db->createCommand()->delete('dwh_d_printername');
			Yii::app()->db->createCommand()->delete('dwh_d_printerdriver');
			Yii::app()->db->createCommand()->delete('dwh_d_printerlocation');
			$printernames = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'printernames';")->queryColumn();
			Yii::app()->db->createCommand()->insert('dwh_d_printername', array('printername' => "Unknown"));
			foreach ($printernames as $printername) {
				foreach (explode(' ', $printername) as $p) {
					Yii::app()->db->createCommand("INSERT INTO dwh_d_printername (printername) VALUES ('" . $p . "') ON DUPLICATE KEY UPDATE printername = VALUES (printername)")->execute();
				}
			}
			$printerdrivers = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'printerdrivers';")->queryColumn();
			Yii::app()->db->createCommand()->insert('dwh_d_printerdriver', array('printerdriver' => "Unknown"));
			foreach ($printerdrivers as $printerdriver) {
				foreach (explode(' ', $printerdriver) as $p) {
					Yii::app()->db->createCommand("INSERT INTO dwh_d_printerdriver (printerdriver) VALUES ('" . $p . "') ON DUPLICATE KEY UPDATE printerdriver = VALUES (printerdriver)")->execute();
				}
			}
			$printerlocations = Yii::app()->puppetdb->createCommand("select DISTINCT value FROM certname_facts WHERE name = 'printerlocations';")->queryColumn();
			Yii::app()->db->createCommand()->insert('dwh_d_printerlocation', array('printerlocation' => "Unknown"));
			foreach ($printerlocations as $printerlocation) {
				foreach (str_getcsv($printerlocation, ' ', '"') as $p) {
					Yii::app()->db->createCommand("INSERT INTO dwh_d_printerlocation (printerlocation) VALUES ('" . $p . "') ON DUPLICATE KEY UPDATE printerlocation = VALUES (printerlocation)")->execute();
				}
			}
			$facts = Yii::app()->puppetdb->createCommand("SELECT certname, (array_agg(value))[4] AS printernb, (array_agg(value))[3] AS printername, (array_agg(value))[1] AS printerdriver, (array_agg(value))[2] AS printerlocation FROM (SELECT certname, name, value FROM certname_facts WHERE name = 'printernb' OR name = 'printernames' OR name = 'printerdrivers' OR name = 'printerlocations' ORDER BY certname, name) AS cf GROUP BY certname;")->queryAll();
			foreach ($facts as $fact) {
				$printernb = $fact['printernb'];
				$id = Yii::app()->db->createCommand("SELECT id FROM dwh_d_host WHERE certname = '" . $fact['certname'] . "'")->queryScalar();
				for ($i = 0; $i < $printernb; $i++) {
					$printername = $fact['printername'] ? $fact['printername'] : "Unknown";
					$printername = explode(' ', $printername);
					$printername = $printername[$i];
					$nid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_printername WHERE printername = '" . $printername . "'")->queryScalar();
					$printerdriver = $fact['printerdriver'] ? $fact['printerdriver'] : "Unknown";
					$printerdriver = explode(' ', $printerdriver);
					$printerdriver = $printerdriver[$i];
					$did = Yii::app()->db->createCommand("SELECT id FROM dwh_d_printerdriver WHERE printerdriver = '" . $printerdriver . "'")->queryScalar();
					$printerlocation = $fact['printerlocation'] ? $fact['printerlocation'] : "Unknown";
					$printerlocation = str_getcsv($printerlocation, ' ', '"');
					$printerlocation = $printerlocation[$i];
					$lid = Yii::app()->db->createCommand("SELECT id FROM dwh_d_printerlocation WHERE printerlocation = '" . $printerlocation . "'")->queryScalar();
					Yii::app()->db->createCommand()->insert('dwh_f_printer', array(
						'host_id' => $id,
						'printername_id' => $nid,
						'printerdriver_id' => $did,
						'printerlocation_id' => $lid,
					));
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
