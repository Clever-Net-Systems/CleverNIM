<?php
$this->pageTitle='Media manager';
$this->breadcrumbs=array(
	'Media manager',
);

$cs = Yii::app()->clientScript;
$cs->registerCoreScript('jquery.ui');
$cs->registerCoreScript('jquery.ui.smoothness');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/elFinder/js/elfinder.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/elFinder/js/i18n/elfinder.fr.js');
$cs->registerCSSFile(Yii::app()->request->baseUrl . '/elFinder/css/elfinder.min.css');
$cs->registerCSSFile(Yii::app()->request->baseUrl . '/elFinder/css/theme.css');

$cs->registerScript('initScript', "
	$().ready(function() {
		var elf = $('#elfinder').elfinder({
			url : '/mediaManager/mmconnector',  // connector URL (REQUIRED)
			lang: 'fr',             // language (OPTIONAL)
		}).elfinder('instance');
	});
");
?>

<br />
<div class="clear"></div>
<div id="elfinder"></div>
