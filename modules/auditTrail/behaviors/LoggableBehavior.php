<?php
class LoggableBehavior extends CActiveRecordBehavior {
	private $_oldattributes = array();

	private function deduceValue($name, $value) {
		// Check whether the value is scalar or object or array of objects
		foreach ($this->Owner->getMetadata()->relations as $relname => $relparams) {
			if ($relparams->foreignKey === $name) {
				switch (get_class($relparams)) {
				case "CBelongsToRelation": case "CHasOneRelation":
					$classname = $relparams->className;
					$model = call_user_func($classname . "::model");
					$obj = $model->findByPk($value);
					if ($obj && isset($obj->_intname)) {
						return $obj->_intname;
					} else {
						return $value;
					}
				default:
					return $value;
				}
			}
		}
		return $value;
	}

	public function afterSave($event) {
		if (get_class($this->Owner) === "AuditTrail") { // Let's not recursively log an AuditTrail object modification
			return parent::afterDelete($event);
		}
		if ($this->Owner->scenario == "import") { // Don't log massive imports
			return parent::afterDelete($event);
		}
		try {
			$username = Yii::app()->user->Name;
			$userid = Yii::app()->user->id;
		} catch(Exception $e) { //If we have no user object, this must be a command line program
			$username = "N/A";
			$userid = null;
		}

		if(empty($username)) {
			$username = "N/A";
		}

		if(empty($userid)) {
			$userid = null;
		}

		$newattributes = $this->Owner->getAttributes();
		$oldattributes = $this->getOldAttributes();

		if (!$this->Owner->isNewRecord) {
			// This is an UPDATE operation
			foreach ($newattributes as $name => $value) {
				if (!empty($oldattributes)) {
					$old = $oldattributes[$name];
				} else {
					$old = '';
				}

				if ($value != $old) {
					$log = new AuditTrail();
					$log->stamp = date('Y-m-d H:i:s');
					$log->user_id = $userid;
					$log->action = 'UPDATE';
					$log->class = get_class($this->Owner);
					$log->class_id = $this->Owner->getPrimaryKey();
					$log->field = $name;
					$log->_intname = $this->Owner->_intname;
					$log->old_value = $this->deduceValue($name, $old);
					$log->new_value = $this->deduceValue($name, $value);
					$log->save();
				}
			}
		} else {
			// This is a CREATE operation
			$log = new AuditTrail();
			$log->stamp = date('Y-m-d H:i:s');
			$log->user_id = $userid;
			$log->action = 'CREATE';
			$log->class = get_class($this->Owner);
			$log->class_id = $this->Owner->getPrimaryKey();
			$log->field = 'N/A';
			$log->_intname = $this->Owner->_intname;
			$log->old_value = '';
			$log->new_value = '';
			$log->save();
		}

		return parent::afterSave($event);
	}

	public function afterDelete($event) {
		if (get_class($this->Owner) === "AuditTrail") { // Let's not recursively log an AuditTrail object modification
			return parent::afterDelete($event);
		}
		try {
			$username = Yii::app()->user->Name;
			$userid = Yii::app()->user->id;
		} catch(Exception $e) {
			$username = "N/A";
			$userid = null;
		}

		if(empty($username)) {
			$username = "N/A";
		}

		if(empty($userid)) {
			$userid = null;
		}

		$log = new AuditTrail();
		$log->stamp = date('Y-m-d H:i:s');
		$log->user_id = $userid;
		$log->action = 'DELETE';
		$log->class = get_class($this->Owner);
		$log->class_id = null;
		$log->field = 'N/A';
		$log->_intname = $this->Owner->_intname;
		$log->old_value = '';
		$log->new_value = '';
		$log->save();

		return parent::afterDelete($event);
	}

	public function afterFind($event) {
		// Save old values
		$this->setOldAttributes($this->Owner->getAttributes());

		return parent::afterFind($event);
	}

	public function getOldAttributes() {
		return $this->_oldattributes;
	}

	public function setOldAttributes($value) {
		$this->_oldattributes = $value;
	}
}
?>
