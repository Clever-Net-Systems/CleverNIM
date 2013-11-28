<?php
class Message extends EZActiveRecord {
	public $message, $category;

	public static function filterData($relation = null) {
		return parent::filterData($relation, __CLASS__);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return Yii::app()->getMessages()->translatedMessageTable;
	}

	function rules(){
		return array(
			array('id,language,translation','required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('language', 'length', 'max'=>16),
			array('translation', 'safe'),
			array('id, language, translation, category, message', 'safe', 'on'=>'search'),
		);
	}

	function relations(){
		return array(
			'source'=>array(self::BELONGS_TO,'MessageSource','id'),
		);
	}

	function attributeLabels(){
		return array(
			'id' => TranslateModule::t('ID'),
			'language' => TranslateModule::t('Language'),
			'translation' => TranslateModule::t('Translation'),
			'category' => MessageSource::model()->getAttributeLabel('category'),
			'message' => MessageSource::model()->getAttributeLabel('message'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->select = 't.*,source.message as message,source.category as category';
		$criteria->with = array('source');
		$criteria->compare('t.language', $this->language, true);
		$criteria->compare('t.translation', $this->translation, true);
		$criteria->compare('source.category', $this->category, true);
		$criteria->compare('source.message', $this->message, true);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
			),
			'criteria' => $criteria,
		));
	}
}
