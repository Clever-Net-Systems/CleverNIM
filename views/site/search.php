<?php
$this->pageTitle = 'Recherche';
$this->breadcrumbs = array(
	'Recherche',
);
?>

<?php if (count($objlist) === 0) { ?>
<?php } else { ?>
<table>
	<thead>
		<tr><td class="left">Relevancy</td><td class="left">Node</td></tr>
	</thead>
	<tbody>
	<?php foreach ($objlist as $obj) { ?>
	<tr>
		<td class="left"><?php echo printf("%.2F", $obj['score']); ?></td>
		<td class="left"><?php echo gettype($obj['model']) === "string" ? $obj['model'] : CHtml::link(CHtml::encode($obj['model']->_intname), array(lcfirst(get_class($obj['model'])) . "/update", "id" => $obj['model']->id, "prevUri" => Yii::app()->request->requestUri), array("class" => "codaPopupTrigger", "rel" => Yii::app()->createUrl(lcfirst(get_class($obj['model'])) . "/coda", array("id" => $obj['model']->id)))); ?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<br />
<div class="pagination">
<?php if (isset($pages)) $this->widget('bootstrap.widgets.TbPager', array('pages' => $pages)); ?>
</div>
<br />
<form id="searchform" action="<?php echo Yii::app()->createUrl('site/search'); ?>" method="get"><input type="text" style="float: none; width: 60%; margin-left: 100px;" class="search" title="Search..." name="q" value="<?php if (isset($q)) echo $q; ?>"></form>
<p>Exemples de recherche :</p>
<ul>
  <li><strong>+10.222.220.1 +dc7900</strong> - tous les postes du site ayant comme routeur 10.222.220.1 et de type HP Compaq dc7900 Small Form Factor
  <li><strong>*20121205*</strong> - tous les postes crees le 5 decembre 2012
</ul>
