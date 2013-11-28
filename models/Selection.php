<?php

class Selection extends EZActiveRecord {
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getOperateur_values($index = null) {
		$t = array(0 => 'ET', 1 => 'OU', );
		return isset($index) ? $t[$index] : $t;
	}
	public static function getOperateur_index($value) {
		$t = array('ET' => 0, 'OU' => 1, );
		return isset($t[$value]) ? $t[$value] : false;
	}

	public $searchfaits;
	public function getAllfaitss() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->faits as $item) {
			$ritems .= CHtml::link(CHtml::encode($item->_intname), array("fait/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("fait/coda", array("id" => $item->id)))) . "<br />\n";
		}
		$ritems .= "</div>";
		return $ritems;
	}

	public function beforeSave() {
		$this->_intname = "{Faits}";
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
		return 'selection';
	}

	public function scopes() {
		return array(
		);
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('operateur', 'required'),
			array('operateur', 'type', 'type' => 'integer'),
			array('operateur', 'numerical', 'integerOnly' => true),
			array('description', 'type', 'type' => 'string'),
			array('description', 'required'),
			array('description', 'length', 'min' => 1),
			array('description', 'length', 'max' => 255),
			array('operateur', 'safe', 'on' => 'search'),
			array('description', 'safe', 'on' => 'search'),
			array('searchfaits', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'faits' => array(self::HAS_MANY, 'Fait', 'selection_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'operateur' => Yii::t('app', 'Operateur'),
			'description' => Yii::t('app', 'Description'),
			'searchfaits' => Yii::t('app', 'Faits'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		if (!Yii::app()->user->checkAccess("Selection.ViewAll") && Yii::app()->user->checkAccess('Selection.ViewSelf')) {
			$criteria->compare('t.user_id', Yii::app()->user->id, false);
		}
		$criteria->compare('t.operateur', $this->operateur, false);
		$criteria->compare('t.description', $this->description, true);
		$ids = Yii::app()->db->createCommand("SELECT selection_id FROM fait WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchfaits . "%"));
		if (isset($this->searchfaits) && ($this->searchfaits !== "") && $ids) {
			$criteria->addInCondition('t.id', $ids);
		} 

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
