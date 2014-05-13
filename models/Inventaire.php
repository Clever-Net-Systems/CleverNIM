<?php

class Inventaire extends EZActiveRecord {
	/* Array for searching on Puppet facts */
	public $searchpuppetfacts = array();

	public function beforeSave() {
		$this->_intname = $this->host->_intname . " " . $this->software . " " . $this->version;
		$this->user_id = Yii::app()->user->id;

		return parent::beforeSave();
	}

	public function tableName() {
		return 'inventaire';
	}

	public function relations() {
		return array(
			'host' => array(self::BELONGS_TO, 'Poste', 'host_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'software' => Yii::t('app', 'Software'),
			'version' => Yii::t('app', 'Version'),
		);
	}

	public static function getFactColumns() {
		$res = array();
		$columns = Yii::app()->puppetdb->createCommand("SELECT DISTINCT name FROM certname_facts")
			->queryAll();
		foreach ($columns as $column) {
			$factname = $column['name'];
			if (in_array($factname, explode(',', Yii::app()->user->getState('extraCols')))) {
				$res[] = array(
						'name' => "searchpuppetfacts[$factname]",
						'header' => "$factname" . '<a href="javascript:$.fn.yiiGridView.update(\'inventaire-grid\', { data:{ delCol: \'' . $factname . '\' } });"><i class="icon-remove-sign"></i></a>',
						'filter' => null,
						'type' => 'raw',
						'value' => "\$data->host->getFact('$factname');"
				      );
			}
		}
		return $res;
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('software', 'type', 'type' => 'string'),
			array('software', 'required'),
			array('software', 'length', 'max' => 255),
			array('version', 'type', 'type' => 'string'),
			array('version', 'required'),
			array('version', 'length', 'max' => 255),
			array('host_id', 'safe', 'on'=>'search'),
			array('searchpuppetfacts', 'safe', 'on'=>'search'),
		);
	}

	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.software', $this->software, true);
		$criteria->compare('t.version', $this->version, true);
		$criteria->compare('t.host_id', $this->host_id, false);

		/* Restriction par groupement */
		if (!Yii::app()->user->checkAccess("Inventory.Admin") && Yii::app()->user->checkAccess('Inventory.AdminGroup')) {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$postes = $user->getPostesOK();
			$criteria->addInCondition('t.host_id', array_map(function ($p) { return $p->id; }, $postes), 'AND');
		}

		/* On filtre par puppet facts ajoutes dynamiquement par l'utilisateur */
		foreach ($this->searchpuppetfacts as $fact => $val) {
			/* Check if fact is in extraCols because column might have been deleted in the meantime */
			if (in_array($fact, explode(',', Yii::app()->user->getState('extraCols')))) {
				if ($val !== "") {
					$certnames = array();
					$certnames = Yii::app()->puppetdb->createCommand("SELECT certname FROM certname_facts WHERE name = :name AND value LIKE :val")->queryColumn(array(":name" => $fact, ":val" => "%" . $val . "%"));
					/* Find corresponding hosts */
					$hostids = Yii::app()->db->createCommand("SELECT id FROM poste WHERE nom_puppet IN (" . "'" . implode("', '", $certnames) . "'" . ")")->queryColumn();
					$criteria->addInCondition('t.host_id', $hostids, 'AND');
				}
			}
		}

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
