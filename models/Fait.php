<?php

class Fait extends EZActiveRecord {
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getFact_values($index = null) {
		$t = array(0 => 'architecture', 1 => 'augeasversion', 2 => 'certname', 3 => 'domain', 4 => 'ecole', 5 => 'environnement', 6 => 'facterversion', 7 => 'fqdn', 8 => 'hardwareisa', 9 => 'hardwaremodel', 10 => 'hostname', 11 => 'id', 12 => 'interfaces', 13 => 'ip6tables_version', 14 => 'ipaddress', 15 => 'ipaddress_eth0', 16 => 'ipaddress_lo', 17 => 'iptables_version', 18 => 'is_virtual', 19 => 'kernel', 20 => 'kernelmajversion', 21 => 'kernelrelease', );
		return isset($index) ? $t[$index] : $t;
	}
	public static function getFact_index($value) {
		$t = array('architecture' => 0, 'augeasversion' => 1, 'certname' => 2, 'domain' => 3, 'ecole' => 4, 'environnement' => 5, 'facterversion' => 6, 'fqdn' => 7, 'hardwareisa' => 8, 'hardwaremodel' => 9, 'hostname' => 10, 'id' => 11, 'interfaces' => 12, 'ip6tables_version' => 13, 'ipaddress' => 14, 'ipaddress_eth0' => 15, 'ipaddress_lo' => 16, 'iptables_version' => 17, 'is_virtual' => 18, 'kernel' => 19, 'kernelmajversion' => 20, 'kernelrelease' => 21, );
		return isset($t[$value]) ? $t[$value] : false;
	}
	public static function getOperateur_values($index = null) {
		$t = array(0 => '=', 1 => '!=', 2 => '>', 3 => '<', 4 => '>=', 5 => '<=', 6 => 'IN', );
		return isset($index) ? $t[$index] : $t;
	}
	public static function getOperateur_index($value) {
		$t = array('=' => 0, '!=' => 1, '>' => 2, '<' => 3, '>=' => 4, '<=' => 5, 'IN' => 6, );
		return isset($t[$value]) ? $t[$value] : false;
	}

	public function beforeSave() {
		$this->_intname = "" . $this->getFact_values($this->fact) . " " . $this->getOperateur_values($this->operateur) . " " . $this->valeur . "";
		$this->user_id = Yii::app()->user->id;

		return parent::beforeSave();
	}

	public function beforeDelete() {
		$this->save();

		return parent::beforeDelete();
	}

	public function afterDelete() {
		return parent::afterDelete();
	}

	public function tableName() {
		return 'fait';
	}

	public function scopes() {
		return array(
		);
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('fact', 'required'),
			array('fact', 'type', 'type' => 'integer'),
			array('fact', 'numerical', 'integerOnly' => true),
			array('valeur', 'type', 'type' => 'string'),
			array('valeur', 'required'),
			array('valeur', 'length', 'min' => 1),
			array('operateur', 'required'),
			array('operateur', 'type', 'type' => 'integer'),
			array('operateur', 'numerical', 'integerOnly' => true),
			array('selection_id', 'required'),
			array('fact', 'safe', 'on' => 'search'),
			array('valeur', 'safe', 'on' => 'search'),
			array('operateur', 'safe', 'on' => 'search'),
			array('selection_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'selection' => array(self::BELONGS_TO, 'Selection', 'selection_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'fact' => Yii::t('app', 'Fact'),
			'valeur' => Yii::t('app', 'Valeur'),
			'operateur' => Yii::t('app', 'Operateur'),
			'selection_id' => Yii::t('app', 'Selection'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		if (!Yii::app()->user->checkAccess("Fait.ViewAll") && Yii::app()->user->checkAccess('Fait.ViewSelf')) {
			$criteria->compare('t.user_id', Yii::app()->user->id, false);
		}
		$criteria->compare('t.fact', $this->fact, false);
		$criteria->compare('t.valeur', $this->valeur, true);
		$criteria->compare('t.operateur', $this->operateur, false);
		$criteria->compare('t.selection_id', $this->selection_id, false);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
