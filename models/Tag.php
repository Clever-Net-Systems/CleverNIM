<?php

class Tag extends EZActiveRecord {
	public function userCanModify() {
		/* The user can modify this tag only if he is part of the restriction group and if all associated nodes are in restriction groups that he has access to */
		$user = User::model()->findByPk(Yii::app()->user->id);
		if (in_array($this->groupement->_intname, array_map(function ($p) { return $p->_intname; }, $user->groupements))) {
			$atleastone = false;
			$ok = true;
			foreach ($this->postes as $poste) {
				if ($user->getPosteOK($poste)) {
					$atleastone = true;
				} else {
					$ok = false;
				}
			}
			if ($atleastone && $ok) {
				return true;
			}
		}
		return false;
	}

	public function groupementsOK() {
		$user = User::model()->findByPk(Yii::app()->user->id);
		if (count($user->getgroupementsIds()) > 0) {
			return Groupement::model()->findAllByPk($user->getgroupementsIds(), array("order" => "_intname"));
		} else {
			return Groupement::model()->findAll(array("order" => "_intname"));
		}
	}

	public function search() {
		$criteria = new CDbCriteria;

		$ids = Yii::app()->db->createCommand("SELECT tag_id FROM valeurparam WHERE _intname LIKE :id")->queryColumn(array(":id" => "%" . $this->searchvaleurs . "%"));
		if (isset($this->searchvaleurs) && ($this->searchvaleurs !== "") && $ids) {
			$criteria->addInCondition('t.id', $ids);
		}
		$criteria->compare('t.type_de_tag_id', $this->type_de_tag_id, false);
		/* Ici on utilise les groupements du user pour restreindre les postes à afficher */
		/* Mais si son groupement est identique à un autre groupement, on affiche quand même les postes des groupements auxquels il n'a pas droit */
		/* Par contre, il ne peut créer un tag qu'avec les groupements auxquels il a droit */
		$user = User::model()->findByPk(Yii::app()->user->id);
		$postes = $user->getPostesOK();
		$criteria->with[] = "postes";
		$criteria->together = true;
		$criteria->addInCondition('postes.id', array_map(function ($p) { return $p->id; }, $postes), 'AND');
		if ($this->searchpostes) {
			$criteria->compare('postes._intname', $this->searchpostes, true);
		}

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}

	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public $searchpostes;
        public function getpostesIds() {
                $q = Yii::app()->db->createCommand("SELECT postes_id FROM poste_tags WHERE tags_id = :id");
                return $q->queryColumn(array(":id" => $this->id));
        }
	public $postesIds = array();
	public function getAllpostess() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->postes as $item) {
			$ritems .= CHtml::link(CHtml::encode($item->_intname), array("poste/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("poste/coda", array("id" => $item->id)))) . "<br />\n";
		}
		$ritems .= "</div>";
		return $ritems;
	}

	public $searchvaleurs;
	public function getAllvaleurss() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->valeurs as $item) {
			$ritems .= $item->_intname . "<br />\n";
		}
		$ritems .= "</div>";
		return $ritems;
	}

	public function beforeSave() {
		$this->_intname = "" . ($this->type_de_tag ? $this->type_de_tag->_intname : "N/A") . "";
		$this->user_id = Yii::app()->user->id;

		return parent::beforeSave();
	}

	public function beforeDelete() {
		$this->postes = array();
		foreach ($this->valeurs as $valeur) {
			$valeur->delete();
		}
		$this->save();

		return parent::beforeDelete();
	}

	public function tableName() {
		return 'tag';
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('type_de_tag_id', 'required'),
			array('groupement_id', 'required'),
			array('postesIds', 'safe'),
			array('searchvaleurs', 'safe', 'on'=>'search'),
			array('type_de_tag_id', 'safe', 'on'=>'search'),
			array('groupement_id', 'safe', 'on'=>'search'),
			array('searchpostes', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'valeurs' => array(self::HAS_MANY, 'Valeurparam', 'tag_id'),
			'type_de_tag' => array(self::BELONGS_TO, 'Typetag', 'type_de_tag_id'),
			'groupement' => array(self::BELONGS_TO, 'Groupement', 'groupement_id'),
			'postes' => array(self::MANY_MANY, 'Poste', 'poste_tags(tags_id, postes_id)'),
		);
	}

	public function attributeLabels() {
		return array(
			'searchvaleurs' => Yii::t('app', 'Valeurs'),
			'type_de_tag_id' => Yii::t('app', 'Type de tag'),
			'groupement_id' => Yii::t('app', 'Groupement'),
			'searchpostes' => Yii::t('app', 'Postes'),
		);
	}
}
