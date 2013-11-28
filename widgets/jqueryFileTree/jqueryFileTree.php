<?php

class jqueryFileTree extends CWidget {
	private $_assetsUrl;
	public $name;
	public $form;
	public $model;
	public $class;

	public function init() {
		if ($this->_assetsUrl === null) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.widgets.jqueryFileTree.assets'), false, -1, YII_DEBUG);
		}
		parent::init();
	}

	protected function registerClientScript() {
		$cs = Yii::app()->clientScript;
		$cs->registerCSSFile($this->_assetsUrl . '/css/jqueryFileTree.css');
		$cs->registerScriptFile($this->_assetsUrl . '/js/jqueryFileTree.js');
		$cs->registerScript('ft_' . $this->name, "
function set" . $this->name . "TmbFromFile(file) {
	$.ajax({
		type: 'POST',
		url: '" . Yii::app()->createUrl('mediaManager/getTmb') . "',
		data: ({ file: file }),
		success: function(data) {
			$('#" . $this->name . "_tmb').attr('src', '/media/.tmb/' + data);
		}
	});
}

jQuery().ready(function () {
	$('#filetree_" . $this->name . "').fileTree({
		root: '/',
		script: '" . Yii::app()->createUrl('mediaManager/ftconnector') . "'
	}, function(file) {
		$('#" . $this->class . "_" . $this->name . "').attr('value', '/media' + file);
		set" . $this->name . "TmbFromFile(file);
	});
	set" . $this->name . "TmbFromFile($('#" . $this->class . "_" . $this->name . "').val().substr(6));
});
		");
	}

	public function run() {
		$this->registerClientScript();
		$this->render('jqueryFileTree', array('name' => $this->name, 'form' => $this->form, 'model' => $this->model));
	}
}
