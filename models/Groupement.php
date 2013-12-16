<?php

class Groupement extends EZActiveRecord {
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
	public $searchfaits;
	public function getAllfaitss() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->faits as $item) {
			$ritems .= CHtml::link(CHtml::encode($item->_intname), array("fait_groupement/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("fait_groupement/coda", array("id" => $item->id)))) . "<br />\n";
		}
		$ritems .= "</div>";
		return $ritems;
	}
	public $searchtags_auto;
	public function getAlltags_autos() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->tags_auto as $item) {
			$ritems .= CHtml::link(CHtml::encode($item->_intname), array("tagauto/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("tagauto/coda", array("id" => $item->id)))) . "<br />\n";
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
		foreach ($this->faits as $f) {
			$f->delete();
		}
		$this->users = array();
		$this->save();

		return parent::beforeDelete();
	}

	public function tableName() {
		return 'groupement';
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('nom', 'type', 'type' => 'string'),
			array('nom', 'required'),
			array('nom', 'unique', 'on' => 'create,import'),
			array('nom', 'length', 'min' => 1),
			array('nom', 'length', 'max' => 255),
			array('nom', 'safe', 'on' => 'search'),
			array('searchtags', 'safe', 'on'=>'search'),
			array('searchfaits', 'safe', 'on'=>'search'),
			array('searchtags_auto', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'tags' => array(self::HAS_MANY, 'Tag', 'groupement_id'),
			'faits' => array(self::HAS_MANY, 'Fait_groupement', 'groupement_id'),
			'tags_auto' => array(self::HAS_MANY, 'Tagauto', 'groupement_id'),
			'users' => array(self::MANY_MANY, 'User', 'user_groupements(groupements_id, users_id)'),
		);
	}

	public function attributeLabels() {
		return array(
			'nom' => Yii::t('app', 'Nom'),
			'searchtags' => Yii::t('app', 'Tags'),
			'searchfaits' => Yii::t('app', 'Faits'),
			'searchtags_auto' => Yii::t('app', 'Tags Auto'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.nom', $this->nom, true);
		$ids = Yii::app()->db->createCommand("SELECT groupement_id FROM tag WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchtags . "%"));
		if (isset($this->searchtags) && ($this->searchtags !== "") && $ids) {
			$criteria->addInCondition('t.id', $ids);
		} 
		$ids = Yii::app()->db->createCommand("SELECT groupement_id FROM fait_groupement WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchfaits . "%"));
		if (isset($this->searchfaits) && ($this->searchfaits !== "") && $ids) {
			$criteria->addInCondition('t.id', $ids);
		} 
		$ids = Yii::app()->db->createCommand("SELECT groupement_id FROM tagauto WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchtags_auto . "%"));
		if (isset($this->searchtags_auto) && ($this->searchtags_auto !== "") && $ids) {
			$criteria->addInCondition('t.id', $ids);
		} 

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}

	public function check($facts) {
		$factok = false; /* Il faut qu'il y ait au moins un fact de juste */
		foreach($this->faits as $fait) {
			if (array_key_exists($fait->fact, $facts) && $fait->checkValue($facts[$fait->fact])) {
				$factok = true;
			} else {
				return false; /* Mais il suffit d'un fact faux pour que le groupement soit faux */
			}
		}
		return $factok;
	}
}
