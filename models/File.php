<?php

class File extends EZActiveRecord {
	public static function filterData($r = null) {
		return parent::filterData($r, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function beforeSave() {
		$this->_intname = $this->filename;
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
		return 'file';
	}

	public function scopes() {
		return array(
		);
	}

	public function rules() {
		return array(
			array('_intname', 'type', 'type' => 'string'),
			array('filename', 'type', 'type' => 'string'),
			array('size', 'type', 'type' => 'integer'),
			array('size', 'numerical', 'integerOnly' => true),
			array('cdate', 'date', 'message' => '{attribute} is not a valid date!', 'format' => 'yyyy-MM-dd'),
			array('filename', 'safe', 'on' => 'search'),
			array('size', 'safe', 'on' => 'search'),
			array('cdate', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'filename' => Yii::t('app', 'Filename'),
			'size' => Yii::t('app', 'Size'),
			'cdate' => Yii::t('app', 'Upload date'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		if (!Yii::app()->user->checkAccess("File.ViewAll") && Yii::app()->user->checkAccess('File.ViewSelf')) {
			$criteria->compare('t.user_id', Yii::app()->user->id, false);
		}
		$criteria->compare('t.filename', $this->filename, true);
		$criteria->compare('t.size', $this->size, true);
		$criteria->compare('t.cdate', $this->cdate, true);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
