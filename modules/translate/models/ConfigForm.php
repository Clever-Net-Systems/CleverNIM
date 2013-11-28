<?php

/**
 * ConfigForm class.
 */
class ConfigForm extends CFormModel {
	public $langselect;
	public $fixedlang;
	public $authorizedlanguages = array();
	public $enableinlinetranslations;

	/**
	 * Declares the validation rules.
	 */
	public function rules() {
		return array(
			array('langselect, fixedlang, authorizedlanguages', 'required'),
			array('langselect', 'length', 'max' => 7),
			array('fixedlang', 'length', 'min' => 5, 'max' => 5),
			array('enableinlinetranslations', 'boolean'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'langselect' => 'Language selection mode',
			'fixedlang' => 'Fixed / default language',
			'authorizedlanguages' => 'Authorized languages',
			'enableinlinetranslations' => 'Enable inline translations',
		);
	}
}
