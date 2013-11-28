<?php

/**
 * OptionsForm class.
 * OptionsForm is the data structure for keeping
 * options form data. It is used by the 'options' action of 'SiteController'.
 */
class AppearanceForm extends CFormModel {
	public $logo;
	public $favicon;
	public $uitheme;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('logo,favicon,uitheme', 'required'),
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
			'logo' => 'Logo',
			'favicon' => 'Favicon',
			'uitheme' => 'Widgets theme',
		);
	}
}
