<?php

class RegistrationController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'application.views.layouts.ccregistration';

	/**
	 * Filters
	 */
	public function filters() {
		return array(
			'rights'
		);
	}

	/**
	 * Lists the actions allowed without authentication
	 */
	public function allowedActions() {
		return 'register,captcha,activate';
	}

	/**
	 * @var string the default controller action
	 */
	public $defaultAction = 'register';

	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') ? array() : array(
			'captcha' => array (
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	/**
	 * Send mail method
	 */
	/*public static function sendMail($email, $subject, $message) {*/
	public static function sendMail($model, $activation_url) {
		$message = new YiiMailMessage;
		$message->view = 'activationMail';
		$message->setBody(array('model' => $model, 'activation_url' => $activation_url), 'text/html');
		$message->addTo($model->email);
		$message->from = Yii::app()->params['adminEmail'];
		Yii::app()->mail->send($message);
	}

	/**
	 * Activate user account
	 */
	public function actionActivate() {
		$email = $_GET['email'];
		$activkey = $_GET['activkey'];
		if ($email && $activkey) {
			$find = User::model()->notsafe()->findByAttributes(array('email' => $email));
			if (!isset($find)) {
				throw new CHttpException(400, Yii::t('app', 'Invalid activation URL. Please do not repeat this request again.'));
			}
			if ($find->status == "banned") {
				throw new CHttpException(400, Yii::t('app', 'Your account is banned. Please do not repeat this request again.'));
			}
			if ($find->status == "active") {
				Yii::app()->user->setFlash('registration', "Your account has already been activated. You can now login.");
				$this->redirect('/site/login');
			}
			if(isset($find->activkey) && ($find->activkey === $activkey)) {
				$find->activkey = md5(microtime());
				$find->status = "active";
				$find->save();
				/* Give user StandardUser role */
				$auth = Yii::app()->authManager;
				$auth->assign('StandardUser', $find->id);
				Yii::app()->user->setFlash('registration', "Your account is activated. You can now login.");
				$this->redirect('/site/login');
			} else {
				throw new CHttpException(400, Yii::t('app', 'Invalid activation URL. Please do not repeat this request again.'));
			}
		} else {
			throw new CHttpException(400, Yii::t('app', 'Invalid activation URL. Please do not repeat this request again.'));
		}
	}

	/**
	 * Register user
	 */
	public function actionRegister() {
		$model = new RegistrationForm;

		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (Yii::app()->user->id) {
			$this->redirect('/site/home');
		} else {
			if (isset($_POST['RegistrationForm'])) {
				$model->attributes = $_POST['RegistrationForm'];
				if ($model->validate()) {
					$sourcePassword = $model->password;
					$model->activkey = md5(microtime() . $model->password);
					$model->password = md5($model->password);
					$model->verifyPassword = md5($model->verifyPassword);
					$model->createtime = time();
					/* TODO lastvisit should be time() or 0 depending on whether the account is immediately active or pending confirmation */
					$model->lastvisit = time();
					/* TODO status depends on workflow */
					$model->status = "registered";
					if ($model->save()) {
						$activation_url = $this->createAbsoluteUrl('/registration/activate', array("activkey" => $model->activkey, "email" => $model->email));
						//$this->sendMail($model->email, "You registered from " . Yii::app()->name, "Please activate you account go to " . $activation_url);
						$this->sendMail($model, $activation_url);
						/*$identity = new UserIdentity($model->username, $sourcePassword);
						$identity->authenticate();
						Yii::app()->user->login($identity, 0);
						$this->redirect(Yii::app()->controller->module->returnUrl);*/
						Yii::app()->user->setFlash('registration', "Thank you for your registration. Please check your email.");
						$this->redirect('/site/login');
					}
				}
			}
			$this->render('application.views.registration.register', array('model' => $model));
		}
	}
}
