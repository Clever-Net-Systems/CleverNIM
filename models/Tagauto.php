<?php

class Tagauto extends EZActiveRecord {
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public $searchfaits;
	public function getAllfaitss() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->faits as $item) {
			$ritems .= CHtml::link(CHtml::encode($item->_intname), array("fait_tagauto/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("fait_tagauto/coda", array("id" => $item->id)))) . "<br />\n";
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
		foreach ($this->faits as $fait) {
			$fait->delete();
		}
		$this->save();

		return parent::beforeDelete();
	}

	public function afterDelete() {
		return parent::afterDelete();
	}

	public function tableName() {
		return 'tagauto';
	}

	public function scopes() {
		return array(
		);
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('nom', 'type', 'type' => 'string'),
			array('nom', 'required'),
			array('nom', 'unique', 'on' => 'create,import'),
			array('nom', 'length', 'min' => 1),
			array('nom', 'length', 'max' => 255),
			array('classe', 'type', 'type' => 'string'),
			array('classe', 'required'),
			array('classe', 'unique', 'on' => 'create,import'),
			array('classe', 'length', 'min' => 1),
			array('classe', 'length', 'max' => 255),
			array('groupement_id', 'required'),
			array('nom', 'safe', 'on' => 'search'),
			array('classe', 'safe', 'on' => 'search'),
			array('searchfaits', 'safe', 'on'=>'search'),
			array('groupement_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'faits' => array(self::HAS_MANY, 'Fait_tagauto', 'tag_id'),
			'groupement' => array(self::BELONGS_TO, 'Groupement', 'groupement_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'nom' => Yii::t('app', 'Nom'),
			'classe' => Yii::t('app', 'Classe'),
			'searchfaits' => Yii::t('app', 'Faits'),
			'groupement_id' => Yii::t('app', 'Groupement'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		if (!Yii::app()->user->checkAccess("Tagauto.ViewAll") && Yii::app()->user->checkAccess('Tagauto.ViewSelf')) {
			$criteria->compare('t.user_id', Yii::app()->user->id, false);
		}
		$criteria->compare('t.nom', $this->nom, true);
		$criteria->compare('t.classe', $this->classe, true);
		$ids = Yii::app()->db->createCommand("SELECT tag_id FROM fait_tagauto WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchfaits . "%"));
		if (isset($this->searchfaits) && ($this->searchfaits !== "") && $ids) {
			$criteria->addInCondition('t.id', $ids);
		} 
		$criteria->compare('t.groupement_id', $this->groupement_id, false);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
