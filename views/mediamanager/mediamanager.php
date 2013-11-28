<?php
$this->pageTitle='Media manager';
$this->breadcrumbs=array(
	'Media manager',
);

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/elfinder.full.js');
$cs->registerCSSFile(Yii::app()->request->baseUrl . '/css/elfinder.css');
$cs->registerScript('initScript', "
	jQuery().ready(function (){
		$('#elfinder').elfinder({
			url : '/mediaManager/mmconnector',
			lang : 'en'
		})
	});
");
?>

<br />
<div id="elfinder"></div>

