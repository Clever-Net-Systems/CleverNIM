<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'register' action of 'EZRegistrationController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;

	public function rules() {
		$rules = array(
			array('username, password, verifyPassword, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => "Incorrect username (length between 3 and 20 characters)."),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => "Incorrect password (minimal length 4 symbols)."),
			array('email', 'email'),
			array('username', 'unique', 'message' => "This user's name already exists."),
			array('email', 'unique', 'message' => "This user's email address already exists."),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => "Retype Password is incorrect."),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => "Incorrect symbols (A-z0-9)."),
		);
		if (isset($_POST['ajax']) && $_POST['ajax']==='registration-form') 
			return $rules;
		else 
			array_push($rules, array('verifyCode', 'captcha', 'allowEmpty' => false));
		return $rules;
	}
}
