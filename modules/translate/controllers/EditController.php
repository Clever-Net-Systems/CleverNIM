<?php

class EditController extends TranslateBaseController
{
	public $defaultAction='admin';
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionCreate($id,$language)
	{
		$model=new Message('create');
		$model->id=$id;
		$model->language=$language;

		if(isset($_POST['Message'])){
			$model->attributes=$_POST['Message'];
			if($model->save())
				$this->redirect(array('missing'));
		}

		$this->render('form', array(
			'model' => $model,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$language)
	{
		$model=$this->translateLoadModel($id,$language);

		if(isset($_POST['Message'])){
			$model->attributes=$_POST['Message'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('form', array(
			'model' => $model,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}
	/**
	 * Deletes a record
	 * @param integer $id the ID of the model to be deleted
	 * @param string $language the language of the model to de deleted
	 */
	public function actionDelete($id,$language)
	{
		if(Yii::app()->getRequest()->getIsPostRequest()){
			$model=$this->translateLoadModel($id,$language);
			if($model->delete()){
				if(Yii::app()->getRequest()->getIsAjaxRequest()){
					echo TranslateModule::t('Message deleted successfully');
					Yii::app()->end();
				}else
					$this->redirect(Yii::app()->getRequest()->getUrlReferrer());
			}
		}else
			throw new CHttpException(400);

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Message('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Message']))
			$model->attributes=$_GET['Message'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Configuration admin
	 */
	public function actionConfig()
	{
		$model = new ConfigForm;
		if(isset($_POST['ConfigForm'])) {
			$model->attributes = $_POST['ConfigForm'];
			if($model->validate()) {
				Yii::app()->config->set('langselect', $model->langselect);
				Yii::app()->config->set('fixedlang', $model->fixedlang);
				Yii::app()->config->set('authorizedlanguages', $model->authorizedlanguages);
				Yii::app()->config->set('enableinlinetranslations', $model->enableinlinetranslations);
				if ($model->langselect == "Fixed") {
					Yii::app()->translate->setLanguage($model->fixedlang);
				}
				Yii::app()->user->setFlash('success', "Your internationalization configuration has been saved.");
				$this->refresh();
			}
		}
		$model->langselect = Yii::app()->config->get('langselect');
		$model->fixedlang = Yii::app()->config->get('fixedlang');
		$model->authorizedlanguages = Yii::app()->config->get('authorizedlanguages');
		$model->enableinlinetranslations = Yii::app()->config->get('enableinlinetranslations');
		$this->render('config', array(
			'model' => $model,
			'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
		));
	}

	public function actionMissing() {
		$model = new MessageSource('search');
		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('pageSize', (int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}
		//$model->unsetAttributes();  // clear any default values

		if (isset($_GET['MessageSource']))
			$model->attributes = $_GET['MessageSource'];

		$model->language = TranslateModule::translator()->getLanguage();

		$this->render('missing', array(
			'model' => $model,
		));
	}
	/**
	 * Deletes a record
	 * @param integer $id the ID of the model to be deleted
	 * @param string $language the language of the model to de deleted
	 */
	public function actionMissingdelete($id)
	{
		if(Yii::app()->getRequest()->getIsPostRequest()){
			$model=MessageSource::model()->findByPk($id);
			if($model->delete()){
				if(Yii::app()->getRequest()->getIsAjaxRequest()){
					echo TranslateModule::t('Message deleted successfully');
					Yii::app()->end();
				}else
					$this->redirect(Yii::app()->getRequest()->getUrlReferrer());
			}
		}else
			throw new CHttpException(400);

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function translateLoadModel($id,$language)
	{
		$model=Message::model()->findByPk(array('id'=>$id,'language'=>$language));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
