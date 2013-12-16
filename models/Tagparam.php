<?php

class Tagparam extends EZActiveRecord {
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getType_values($index = null) {
		$t = array(0 => 'Nombre', 1 => 'Oui/Non', 2 => 'Liste', );
		return isset($index) ? $t[$index] : $t;
	}
	public static function getType_index($value) {
		$t = array('Nombre' => 0, 'Oui/Non' => 1, 'Liste' => 2, );
		return isset($t[$value]) ? $t[$value] : false;
	}

	public $searchvaleurs;
	public function getAllvaleurss() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->valeurs as $item) {
			$ritems .= CHtml::link(CHtml::encode($item->_intname), array("valeurparam/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("valeurparam/coda", array("id" => $item->id)))) . "<br />\n";
		}
		$ritems .= "</div>";
		return $ritems;
	}

	public function beforeSave() {
		$this->_intname = "" . $this->nom . "";
		$this->user_id = Yii::app()->user->id;

		return parent::beforeSave();
	}

	public function beforeDelete() {
		$this->save();

		return parent::beforeDelete();
	}

	public function tableName() {
		return 'tagparam';
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('nom', 'type', 'type' => 'string'),
			array('nom', 'required'),
			array('nom', 'length', 'min' => 1),
			array('nom', 'length', 'max' => 255),
			array('description', 'type', 'type' => 'string'),
			array('type', 'required'),
			array('type', 'type', 'type' => 'integer'),
			array('type', 'numerical', 'integerOnly' => true),
			array('possibles', 'type', 'type' => 'string'),
			array('type_de_tag_id', 'required'),
			array('nom', 'safe', 'on' => 'search'),
			array('description', 'safe', 'on' => 'search'),
			array('type', 'safe', 'on' => 'search'),
			array('possibles', 'safe', 'on' => 'search'),
			array('searchvaleurs', 'safe', 'on'=>'search'),
			array('type_de_tag_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'valeurs' => array(self::HAS_MANY, 'Valeurparam', 'parametre_id'),
			'type_de_tag' => array(self::BELONGS_TO, 'Typetag', 'type_de_tag_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'nom' => Yii::t('app', 'Nom'),
			'description' => Yii::t('app', 'Description'),
			'type' => Yii::t('app', 'Type'),
			'possibles' => Yii::t('app', 'Possibles'),
			'searchvaleurs' => Yii::t('app', 'Valeurs'),
			'type_de_tag_id' => Yii::t('app', 'Type de tag'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.nom', $this->nom, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.type', $this->type, false);
		$criteria->compare('t.possibles', $this->possibles, true);
		$ids = Yii::app()->db->createCommand("SELECT parametre_id FROM valeurparam WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchvaleurs . "%"));
		if (isset($this->searchvaleurs) && ($this->searchvaleurs !== "") && $ids) {
			$criteria->addInCondition('t.id', $ids);
		} 
		$criteria->compare('t.type_de_tag_id', $this->type_de_tag_id, false);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
