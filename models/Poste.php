<?php

class Poste extends EZActiveRecord {
	/* Array for searching on Puppet facts */
	public $searchpuppetfacts = array();
	public $searchtype;

	public $searchtags;
        public function gettagsIds() {
                $q = Yii::app()->db->createCommand("SELECT tags_id FROM poste_tags WHERE postes_id = :id");
                return $q->queryColumn(array(":id" => $this->id));
        }
	public $tagsIds = array();

	public function beforeSave() {
		$this->_intname = $this->hostname;
		$this->user_id = Yii::app()->user->id;

		return parent::beforeSave();
	}

	public function beforeDelete() {
		foreach ($this->tags as $tag) {
			if (count($tag->postes) == 1) { /* Pas d'autres postes associes a ce tag, on supprime le tag */
				$tag->delete();
			}
		}
		$this->tags = array();
		foreach ($this->inventaires as $inventaire) {
			$inventaire->delete();
		}
		$this->save();

		return parent::beforeDelete();
	}

	public function afterDelete() {
		return parent::afterDelete();
	}

	public function tableName() {
		return 'poste';
	}

	public function scopes() {
		return array(
		);
	}

	public function relations() {
		return array(
			'tags' => array(self::MANY_MANY, 'Tag', 'poste_tags(postes_id, tags_id)'),
			'inventaires' => array(self::HAS_MANY, 'Inventaire', 'host_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'hostname' => Yii::t('app', 'Hostname'),
			'nom_puppet' => Yii::t('app', 'Nom Puppet'),
			'numero_de_serie' => Yii::t('app', 'Numéro de série'),
			'routeur' => Yii::t('app', 'Routeur'),
			'creation' => Yii::t('app', 'Date Creation'),
			'contact' => Yii::t('app', 'Date Contact'),
			'searchtags' => Yii::t('app', 'Tags'),
		);
	}

	public function nameRule($attribute, $params) {
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('hostname', 'type', 'type' => 'string'),
			array('hostname', 'required'),
			array('hostname', 'unique', 'on' => 'create,import'),
			array('hostname', 'ext.validators.nommageSEMNom'),
			array('nom_puppet', 'type', 'type' => 'string'),
			array('nom_puppet', 'unique', 'on' => 'create,import'),
			array('nom_puppet', 'length', 'max' => 255),
			array('nom_puppet', 'default', 'setOnEmpty' => true, 'value' => ""),
			array('numero_de_serie', 'type', 'type' => 'string'),
			array('numero_de_serie', 'required'),
			array('numero_de_serie', 'unique', 'on' => 'create,import'),
			array('numero_de_serie', 'length', 'min' => 1),
			array('numero_de_serie', 'length', 'max' => 255),
			array('routeur', 'type', 'type' => 'string'),
			array('routeur', 'required', 'on' => 'create'),
			array('routeur', 'ext.validators.nommageSEMRouteur'),
			array('creation', 'date', 'message' => '{attribute} is not a valid date!', 'format' => 'yyyy-MM-dd H:m:s'),
			array('creation', 'required'),
			array('contact', 'date', 'message' => '{attribute} is not a valid date!', 'format' => 'yyyy-MM-dd H:m:s', 'allowEmpty' => true),
			array('contact', 'default', 'setOnEmpty' => true, 'value' => null),
			//array('contact', 'required'),
			array('tagsIds', 'safe'),
			array('hostname', 'safe', 'on' => 'search'),
			array('nom_puppet', 'safe', 'on' => 'search'),
			array('numero_de_serie', 'safe', 'on' => 'search'),
			array('routeur', 'safe', 'on' => 'search'),
			array('creation', 'safe', 'on' => 'search'),
			array('contact', 'safe', 'on' => 'search'),
			array('searchtags', 'safe', 'on'=>'search'),
			array('searchtype', 'safe', 'on'=>'search'),
			array('numero_de_serie', 'match', 'pattern' => '/^[a-zA-Z0-9-]+$/'),
			array('searchpuppetfacts', 'safe', 'on'=>'search'),
		);
	}

	public function getOSIcon() {
		switch ($this->getFact("operatingsystem")) {
			case "Ubuntu": return "1381414539_start-here-ubuntuoriginal.png"; break;
			case "Linux": return "1381413220_Linux.png"; break;
			case "Windows": return "1381413289_32-windows8.png"; break;
			case "Mac": return "1381413316_snow_leopard.png"; break;
			default: return "1381413446_help.png"; break;
		}
	}

	public function getFacts() {
		$facts = Yii::app()->puppetdb->createCommand()
			->select('name, value')
			->from('certname_facts')
			->where('certname = :certname', array('certname' => $this->nom_puppet))
			->order('name')
			->queryAll();
		return $facts;
	}

	public function getFact($fact) {
		$value = Yii::app()->puppetdb->createCommand()
			->select('value')
			->from('certname_facts')
			->where('certname = :certname AND name = :fact', array('certname' => $this->nom_puppet, 'fact' => $fact))
			->queryScalar();
		return $value;
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
						'header' => "$factname" . '<a href="javascript:$.fn.yiiGridView.update(\'poste-grid\', { data:{ delCol: \'' . $factname . '\' } });"><img src=\'/images/cross.png\' alt=\'Supprimer la colonne\'/></a>',
						'filter' => null,
						'type' => 'raw',
						'value' => "\$data->getFact('$factname');"
				      );
			}
		}
		return $res;
	}

	public static function getFactColumnsList() {
		$res = array();
		$columns = Yii::app()->puppetdb->createCommand("SELECT DISTINCT name FROM certname_facts")
			->queryAll();
		foreach ($columns as $column) {
			$factname = $column['name'];
			$res[$factname] = $factname;
		}
		ksort($res);
		return $res;
	}

	/* Version avec les icones */
	public function getAlltagss() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->tags as $item) {
			$ritems .= CHtml::image($item->type_de_tag->icone) . "&nbsp;" . CHtml::link(CHtml::encode($item->_intname), array("tag/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("tag/coda", array("id" => $item->id)))) . "<br />\n";
		}
		$ritems .= "</div>";
		return $ritems;
	}
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function search() {
		$criteria = new CDbCriteria;

		if (!Yii::app()->user->checkAccess("Poste.ViewAll") && Yii::app()->user->checkAccess('Poste.ViewSelf')) {
			$criteria->compare('t.user_id', Yii::app()->user->id, false);
		}
		$criteria->compare('t.hostname', $this->hostname, true);
		$criteria->compare('t.routeur', $this->routeur, true);
		$criteria->compare('t.nom_puppet', $this->nom_puppet, true);
		$criteria->compare('t.numero_de_serie', $this->numero_de_serie, true);
		$criteria->compare('t.creation', $this->creation, true);
		$criteria->compare('t.contact', $this->contact, true);
		if ($this->searchtags) {
			$criteria->with[] = "tags";
			$criteria->together = true;
			$criteria->compare('tags._intname', $this->searchtags, true);
		}
		if ($this->searchtype === "Inconnus") {
			$criteria->addInCondition('t.nom_puppet', array(null, '', 'semcloner-unset'), 'AND');
		}
		/* Restriction par groupement */
		$user = User::model()->findByPk(Yii::app()->user->id);
		$postes = $user->getPostesOK();
		$criteria->addInCondition('t.id', array_map(function ($p) { return $p->id; }, $postes), 'AND');

		/* On filtre par puppet facts ajoutes dynamiquement par l'utilisateur */
		foreach ($this->searchpuppetfacts as $fact => $val) {
			/* Check if fact is in extraCols because column might have been deleted in the meantime */
			if (in_array($fact, explode(',', Yii::app()->user->getState('extraCols')))) {
				if ($val !== "") {
					$certnames = array();
					$certnames = Yii::app()->puppetdb->createCommand("SELECT certname FROM certname_facts WHERE name = :name AND value LIKE :val")->queryColumn(array(":name" => $fact, ":val" => "%" . $val . "%"));
					$criteria->addInCondition('t.nom_puppet', $certnames);
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
