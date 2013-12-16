<?php

class Typetag extends EZActiveRecord {
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public $searchtags;
	public function getAlltagss() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->tags as $item) {
			$ritems .= CHtml::link(CHtml::encode($item->_intname), array("tag/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("tag/coda", array("id" => $item->id)))) . "<br />\n";
		}
		$ritems .= "</div>";
		return $ritems;
	}
	public $searchparametre;
	public function getAllparametres() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->parametre as $item) {
			$ritems .= $item->_intname . "<br />\n";
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
		foreach ($this->parametre as $p) {
			$p->delete();
		}
		$this->save();

		return parent::beforeDelete();
	}

	public function tableName() {
		return 'typetag';
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
			array('description', 'type', 'type' => 'string'),
			array('description', 'length', 'min' => 1),
			array('description', 'length', 'max' => 255),
			array('icone', 'type', 'type' => 'string'),
			array('nom', 'safe', 'on' => 'search'),
			array('classe', 'safe', 'on' => 'search'),
			array('description', 'safe', 'on' => 'search'),
			array('icone', 'safe', 'on' => 'search'),
			array('searchtags', 'safe', 'on'=>'search'),
			array('searchparametre', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'tags' => array(self::HAS_MANY, 'Tag', 'type_de_tag_id'),
			'parametre' => array(self::HAS_MANY, 'Tagparam', 'type_de_tag_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'nom' => Yii::t('app', 'Nom'),
			'classe' => Yii::t('app', 'Classe'),
			'description' => Yii::t('app', 'Description'),
			'icone' => Yii::t('app', 'Icone'),
			'searchtags' => Yii::t('app', 'Tags'),
			'searchparametre' => Yii::t('app', 'Paramètre'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.nom', $this->nom, true);
		$criteria->compare('t.classe', $this->classe, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.icone', $this->icone, true);
		$ids = Yii::app()->db->createCommand("SELECT type_de_tag_id FROM tag WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchtags . "%"));
		if (isset($this->searchtags) && ($this->searchtags !== "") && $ids) {
			$criteria->addInCondition('t.id', $ids);
		} 
		$ids = Yii::app()->db->createCommand("SELECT type_de_tag_id FROM tagparam WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchparametre . "%"));
		if (isset($this->searchparametre) && ($this->searchparametre !== "") && $ids) {
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
