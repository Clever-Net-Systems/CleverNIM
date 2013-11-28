<?php

class BackupController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'application.views.layouts.cchome';

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
	public $defaultAction = 'backup';

	public function mysqldump() {
		echo "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;\n\n";
		$connection = Yii::app()->db;
		$command = $connection->createCommand("SHOW TABLES;");
		$rows = $command->queryAll(false);
		if (count($rows) == 0)
			echo "/* No tables */\n";
		else {
			foreach ($rows as $row) {
				$this->mysqldump_table_structure($row[0]);
				$this->mysqldump_table_data($row[0]);
			}
		}
		echo "/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;\n\n";
		echo "-- Dump completed on " . date("Y-m-d H:i:s") . "\n";
	}

	private function mysqldump_table_structure($table) {
		echo "/* Table structure for table `$table` */\n\n";
		/* TODO Ca ne fonctionne pas parce qu'on doit supprimer les tables dans un certain ordre pour garder le referential integrity */
		/* TODO De toute façon il faut trouver une solution pour sauvegarder tout */
		echo "DROP TABLE IF EXISTS `$table`;\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\n";
		$connection = Yii::app()->db;
		$command = $connection->createCommand("SHOW CREATE TABLE `$table`;");
		$rows = $command->queryAll(true);
		if ($rows) {
			echo str_replace("\n", "", $rows[0]['Create Table']) . ";\n";
		}
		echo "/*!40101 SET character_set_client = @saved_cs_client */;\n\n";
	}

	private function mysqldump_table_data($table) {
		echo "/* Dumping data for table `$table` */\n";
		$connection = Yii::app()->db;
		$command = $connection->createCommand("SELECT * FROM `$table`;");
		$rows = $command->queryAll(false);
		foreach ($connection->schema->getTable($table)->columns as $col) {
			$schema[] = $col->type;
		}
		foreach ($rows as $row) {
			echo "INSERT INTO `$table` VALUES (";
			$i = 0;
			foreach ($row as $cell) {
				if (!$cell) {
					echo "''";
				} else {
					echo ($schema[$i] == "integer") ? $cell : $connection->quoteValue($cell);
				}
				if ($i < (count($row) - 1)) {
					echo ", ";
				}
				$i++;
			}
			echo ");\n";
		}
		echo "\n";
	}

	/**
	 * Checks whether the passed directory entry is a module
	 */
	private function isModule($m) {
		return ($m != '.') && ($m != '..') && is_dir(Yii::app()->modulePath . DIRECTORY_SEPARATOR . $m);
	}

	/**
	 * Returns the list of available modules
	 */
	private function getModules() {
		$modules = scandir(Yii::app()->modulePath);
		$modules = array_filter($modules, array($this, 'isModule'));
		return $modules;
	}

	/**
	 * Returns the list of classes in a path
	 */
	private function getClasses($path) {
		$files = scandir($path);
		$models = array();
		foreach ($files as $f) {
			if (stripos($f, '.php') !== false) {
				if (($f !== 'EZActiveRecord.php') && (stripos($f, 'Form.php') === false)) {
					$models[] = str_ireplace('.php', '', $f);
				}
			}
		}
		return $models;
	}

	/**
	 * This function finds the order in which to drop tables to avoid referential integrity constraint violations
	 */
	private function dropTables() {
		$models = $this->getClasses('protected' . DIRECTORY_SEPARATOR . 'models');
		foreach ($this->getModules() as $module) {
			if (is_dir(join(DIRECTORY_SEPARATOR, array(Yii::app()->modulePath, $module, 'models')))) {
				$models = array_merge($models, $this->getClasses(join(DIRECTORY_SEPARATOR, array(Yii::app()->modulePath, $module, 'models'))));
			}
		}
		$m = array();
		foreach ($models as $model) {
			if (function_exists($model::model) && isset($model::model()->relations)) {
				$m[] = $model;
			}
		}
		return $m;
	}

	/**
	 * This is the default 'backup' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionBackup() {
		if (isset($_POST['action']) && $_POST['action'] == "restore") {
			Yii::app()->user->setFlash('error', "Cette fonctionnalité n'est pas encore active.");
			$this->render('application.views.backup.backup');
			Yii::app()->end();
		}
		if (isset($_POST['yt0'])) {
			foreach (Yii::app()->log->routes as $route) { /* Disable rendering of yiidebugtb inside SQL file */
				if ($route instanceof XWebDebugRouter) {
					$route->enabled = false;
				}
			}
			header('Content-type: text/plain');
			header('Content-Disposition: attachment; filename=ezbackup_' . date('YmdHis') . '.sql');
			header('Cache-Control: max-age=0');
			echo "/* Dump generated by ezwebapp.com */\n\n";
			$this->mysqldump();
			//yiilog($this->dropTables());
			Yii::app()->end();
		}
		$this->render('application.views.backup.backup');
	}

	/**
	 * This is the action to restore data.
	 */
	/*public function actionRestore() {
		Yii::app()->user->setFlash('error', "Cette fonctionnalité n'est pas encore active.");
		$this->render('application.views.backup.restore');
		Yii::app()->end();
		// First check if we're trying to upload but that has failed because of size
		if (isset($_SERVER['REQUEST_METHOD']) && (strtolower($_SERVER['REQUEST_METHOD']) == "post") && empty($_FILES)) {
			$maxsize = ini_get('post_max_size');
			Yii::app()->user->setFlash('error', "Erreur lors du téléchargement. Le fichier dépasse la taille maximale de " . $maxsize . " octets.");
		}
		if (isset($_POST['yt0']) && ($_POST['yt0'] == "Restaurer la base")) {
			$dump = CUploadedFile::getInstanceByName('dump');
			if (!$dump) {
				Yii::app()->user->setFlash('error', "Une erreur inconnue a été rencontrée lors du téléchargement de la sauvegarde");
			} else {
				if ($dump->getHasError()) {
					Yii::app()->user->setFlash('error', "L'erreur suivante a été rencontrée lors du téléchargement de la sauvegarde: " . $dump->getError());
				} else {
					if ($dump->saveAs(sys_get_temp_dir() . "/" . $dump->name)) {
						$connection = Yii::app()->db;
						// Temporarily make sure that autoCommit is false to make sure that rollback will work on InnoDB tables
						$oldautocommit = $connection->getAutoCommit();
						$connection->setAutoCommit(false);
						$transaction = $connection->beginTransaction();
						$queries = fopen(sys_get_temp_dir() . "/" . $dump->name, "r");
						if ($queries) {
							try {
								while (($query = fgets($queries)) !== false) {
									$query = trim($query);
									if ((strpos($query, "/*") !== 0) && ($query !== "") && (strpos($query, "--") !== 0)) {
										$connection->createCommand($query)->execute();
									}
								}
								if (!feof($queries)) {
									$transaction->rollBack();
									Yii::app()->user->setFlash('error', "Erreur inattendue lors de la lecture de la sauvegarde.");
								} else {
									$transaction->commit();
									Yii::app()->user->setFlash('success', "Le dump " . $dump->name . " a été restauré avec succès.");
								}
							}
							catch (exception $e) {
								Yii::app()->user->setFlash('error', "Erreur lors de l'exécution d'une requête SQL: " . $e->getMessage());
								$transaction->rollBack();
							}
							fclose($queries);
						}
						$connection->setAutoCommit($oldautocommit);
					} else {
						Yii::app()->user->setFlash('error', "Le dump " . $dump->name . "n'a pas pu être restauré.");
					}
				}
			}
		}
		$this->render('application.views.backup.restore');
	}*/
}
