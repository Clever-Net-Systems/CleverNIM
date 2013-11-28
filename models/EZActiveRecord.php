<?php

/**
 * Common base class for all CActiveRecord classes
 */
class EZActiveRecord extends CActiveRecord {
	/**
	 * Allows to check if the duration is 12d34h56m formatted
	 */
	public function dhm($attribute, $params) {
		if (h2m($this->$attribute) === FALSE) {
			$this->addError($attribute, "Please use a 12d34h56m format to specify a duration");
		}
	}

	/* Allows to check whether in a "1:1" relationship, the destination is already linked with another object */
        public function freelink($attribute, $params) {
                if (isset($this->$params['relname']) && isset($this->$params['relname']->$params['invrelname']) && ($this->$params['relname']->$params['invrelname']->_intname !== $this->_intname)) {
			$this->addError($attribute, "This " . $params['relname'] . " is already linked to " . $this->$params['relname']->$params['invrelname']->_intname);
                }
        }

	/*
	 * Filter for duration values
	 */
	public function h2m($value) {
		return h2m($value);
	}

	/*
	 * Filter for CAN_BELONG_TO relations where the value for null comes as 0 from the form
	 */
	public function zeroToNull($value) {
		return ($value == 0) ? null : $value;
	}

	/* Used by cascadeDelete to prevent graph cycles during deletion. Stores class and id */
	public static $cascadedObjects = array();

	public function beforeSave() {
		//yiilog("Saving " . $this->_intname);
		return parent::beforeSave();
	}

	/**
	 * Recursively check which objects to delete
	 * @param object $obj the object to be checked
	 */
	public function cascadeDelete($obj, $reallydelete = false) {
		/* We've already seen this object */
		if (in_array(get_class($obj) . $obj->id, EZActiveRecord::$cascadedObjects)) {
			return null;
		}
		EZActiveRecord::$cascadedObjects[] = get_class($obj) . $obj->id;
		$res = array();
		foreach ($obj->getMetadata()->relations as $relname => $relparams) {
			/* There's nothing to do for CHasManyManyRelation and CBelongsToRelation */
			if (get_class($relparams) == "CHasOneRelation") { /* This object references another object that should be deleted too */
				if ($obj->$relname) {
					$sub = $this->cascadeDelete($obj->$relname, $reallydelete);
					if ($sub)
						$res= array_merge($res, $sub);
				}
			}
			if (get_class($relparams) == "CHasManyRelation") { /* This object references other objects that should be deleted too */
				foreach ($obj->$relname as $obj2) {
					$sub = $this->cascadeDelete($obj2, $reallydelete);
					if ($sub)
						$res = array_merge($res, $sub);
				}
			}
		}
		$res[] = $obj;
		if ($reallydelete) {
			if ($obj->delete()) {
				Yii::app()->user->setFlash('success', "Suppression de " . $obj->_intname . " réussie");
			} else {
				Yii::app()->user->setFlash('error', "Suppression de " . $obj->_intname . " échouée");
			}
		}

		return $res;
	}

	/*
	 * filterData returns relevant records for CGridView filters
	 * $relation is the class for which the records are relevant
	 * @return CHtml data
	 */
	public static function filterData($relation, $className) {
		$model = call_user_func($className . "::model");
		if ($relation == null) {
			return CHtml::listData($model->findAll(array('order' => '_intname')), 'id', '_intname');
		} else {
			return CHtml::listData($model->with(array($relation => array('select' => false, 'joinType' => 'INNER JOIN')))->findAll(array('order' => 't._intname')), 'id', '_intname');
		}
	}

	/**
	 * @return array behaviors for this model.
	 */
	public function behaviors() {
		return array(
			'ERememberFiltersBehavior' => array(
				'class' => 'application.components.ERememberFiltersBehavior',
				'defaults' => array(),
				'defaultStickOnClear' => false
			),
			'CAdvancedArBehavior' => array(
				'class' => 'application.components.CAdvancedArBehavior'
			),
			'CCachedFindBehavior' => array(
				'class' => 'application.components.CCachedFindBehavior'
			),
			'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior',
		);
	}
}
