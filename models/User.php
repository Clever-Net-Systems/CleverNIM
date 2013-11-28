<?php

class User extends EZActiveRecord {
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var string $status
	 * @var string $avatar
	 */

	/*
	 * getPostesOK() renvoie la liste des postes qui sont gérables par l'utilisateur, en fonction des groupements auxquels il a droit
	*/
	public function getPostesOK() {
		$postes = array();
		/* TODO Hack parce que les postes du CO/PO ont un agent qui remonte pas les facts */
		if ($this->username === "admin") {
			return Poste::model()->findAll();
		}
		/* On récupère d'abord les groupements du User */
		$groupements = Groupement::model()->findAllByPk($this->getgroupementsIds());
		foreach ($groupements as $groupement) {
			/* On récupère la liste des facts du groupement et on en crée la jointure pour déterminer les postes qui matchent (en live) */
			$q = array();
			foreach ($groupement->faits as $fait) {
				switch (Fait_groupement::getOperateur_values($fait->operateur)) {
					case "=": $val = "= '" . $fait->valeur ."'"; break;
					case "!=": $val = "!= '" . $fait->valeur ."'"; break;
					case ">": $val = "> '" . $fait->valeur ."'"; break;
					case "<": $val = "< '" . $fait->valeur ."'"; break;
					case ">=": $val = ">= '" . $fait->valeur ."'"; break;
					case "<=": $val = "<= '" . $fait->valeur ."'"; break;
					case "IN": $val = "IN (" . "'" . str_replace(',', "','", $fait->valeur) . "'" .")"; break;
					default: $val = "= '" . $fait->valeur ."'"; break;
				}
				$q[] = "(name = '" . $fait->fact . "' AND value " . $val . ")";
			}
			if (count($q) > 0) {
				$certnames = Yii::app()->puppetdb->createCommand("SELECT certname, count(*) FROM certname_facts WHERE " . implode(' OR ', $q) . " GROUP BY certname having count(*) = " . count($q))->queryAll();
				foreach ($certnames as $certname) {
					$poste = Poste::model()->findByAttributes(array('nom_puppet' => $certname));
					if ($poste) {
						$postes[] = $poste;
					}
				}
			}
		}
		/* On retourne aussi les postes qui n'ont pas encore remonté leurs facts */
		$postes = array_merge($postes, Poste::model()->findAllByAttributes(array('nom_puppet' => null)));
		$postes = array_merge($postes, Poste::model()->findAllByAttributes(array('nom_puppet' => "semcloner-unset")));
		return $postes;
	}

	public $searchgroupements;
        public function getgroupementsIds() {
                $q = Yii::app()->db->createCommand("SELECT groupements_id FROM user_groupements WHERE users_id = :id");
                return $q->queryColumn(array(":id" => $this->id));
	}
	public $groupementsIds = array();
	public function getAllgroupementss() {
		$ritems = "<div class=\"listbox\">";
		foreach ($this->groupements as $item) {
			$ritems .= CHtml::link(CHtml::encode($item->_intname), array("groupement/update", "id" => $item->id), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl("groupement/coda", array("id" => $item->id)))) . "<br />\n";
		}
		$ritems .= "</div>";
		return $ritems;
	}

	/**
	 * Object name
	 */
	public function getNom() {
		return $this->username;
	}

	public function beforeSave() {
		$this->_intname = "" . $this->username;

		return parent::beforeSave();
	}

	public function beforeDelete() {
		$this->groupements = array();
		$this->save();

		return parent::beforeDelete();
	}

	public static function filterData($relation = null) {
		return parent::filterData(null, __CLASS__);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array behaviors for this model.
	 */
	public function behaviors() {
		/* TODO yiilog(array_merge(parent::behaviors(), array(
			'swBehavior' => array(
				'class' => 'application.extensions.simpleWorkflow.SWActiveRecordBehavior',
			),
		)));*/
		return array_merge(parent::behaviors(), array(
			'swBehavior' => array(
				'class' => 'application.extensions.simpleWorkflow.SWActiveRecordBehavior',
				'statusAttribute' => 'status',
				'defaultWorkflow' => 'swSimpleUserRegistration',
				'enableEvent' => false,
			),
		));
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return array(
			//array('username, password, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => "Nom d'utilisateur incorrect (longueur entre 3 et 20 caractères)."),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => "Mot de passe incorrect (minimum 4 caractères)."),
			array('email', 'email'),
			array('lang', 'length', 'min' => 5, 'max' => 5),
			array('username', 'unique', 'message' => "Cet utilisateur existe déjà."),
			array('email', 'unique', 'message' => "Cet email existe déjà."),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => "Caractères incorrects (A-z0-9)."),
			array('status', 'SWValidator'),
			array('username, email, lang, createtime, lastvisit, status', 'required'),
			array('status', 'length', 'max' => 50, 'min' => 1),
			array('avatar', 'length', 'max' => 50),
			array('createtime, lastvisit', 'numerical', 'integerOnly'=>true),
			array('username, email, lang, createtime, lastvisit, status, avatar', 'safe', 'on'=>'search'),
			array('username, status, createtime, lastvisit', 'unsafe', 'on' => 'updateself'),
			array('groupementsIds', 'safe'),
			array('searchgroupements', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'groupements' => array(self::MANY_MANY, 'Groupement', 'user_groupements(users_id, groupements_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>"Utilisateur",
			'password'=>"Mot de passe",
			'verifyPassword'=>"Vérification du mot de passe",
			'email'=>"Email",
			'lang'=>"Language",
			'verifyCode'=>"Code de vérification",
			'id' => "Id",
			'activkey' => "Clé d'activation",
			'createtime' => "Date d'enregistrement",
			'lastvisit' => "Dernière visite",
			'status' => "Statut",
			'avatar' => "Avatar",
			'searchgroupements' => Yii::t('app', 'Groupements'),
		);
	}
	
	public function scopes()
	{
		return array(
			'active' => array(
				'condition' => 'status = "active"',
			),
			'notactvie' => array(
				'condition' => 'status = "registered"',
			),
			'banned' => array(
				'condition' => 'status = "banned"',
			),
			'notsafe' => array(
				'select' => 'id, username, password, lang, email, activkey, createtime, lastvisit, status',
			),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('username', $this->username, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('lang', $this->lang, false);
		$criteria->compare('createtime', $this->createtime, true);
		$criteria->compare('lastvisit', $this->lastvisit, true);
		$criteria->compare('status', $this->status, false);
		$criteria->compare('avatar', $this->avatar, true);
		$ids = Yii::app()->db->createCommand("SELECT users_id FROM user_groupements WHERE groupements_id = :id")->queryColumn(array(":id" => $this->searchgroupements));
		if (count($ids)) {
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
