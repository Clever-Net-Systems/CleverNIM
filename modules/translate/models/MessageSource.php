<?php
class MessageSource extends EZActiveRecord {
	public $language;

	public static function filterData($relation = null) {
		return parent::filterData($relation, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return Yii::app()->getMessages()->sourceMessageTable;
	}

	function rules() {
		return array(
			array('category,message', 'required'),
			array('category', 'length', 'max' => 32),
			array('message', 'safe'),
			array('id, category, message,language', 'safe', 'on' => 'search'),
		);
	}

	function relations() {
		return array(
			'mt' => array(self::HAS_MANY, 'Message', 'id', 'joinType' => 'inner join'),
		);
	}
	function attributeLabels() {
		return array(
			'id' => TranslateModule::t('ID'),
			'category' => TranslateModule::t('Category'),
			'message' => TranslateModule::t('Message'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->addCondition('not exists (select `id` from `' . Message::model()->tableName() . '` `m` where `m`.`language`=:lang and `m`.id=`t`.`id`)');
		$criteria->compare('t.category', $this->category, false);
		$criteria->compare('t.message', $this->message, true);
		$criteria->params[':lang'] = $this->language;

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
