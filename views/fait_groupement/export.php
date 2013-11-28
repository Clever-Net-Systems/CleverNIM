<?php
$this->pageTitle = Yii::t('app', 'Export Fait_groupement records');
$this->breadcrumbs = array(
	Yii::t('app', 'Export Fait_groupement records'),
);
?><style>
#sortable1, #sortable2 { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: left; margin-right: 10px; }
#sortable1 li, #sortable2 li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px; }
#exportcolchooser {
	display: inline-block;
width: 960px;
}
</style>
<script>
$(function() {
	$( "#sortable1, #sortable2" ).sortable({
		connectWith: ".connectedSortable"
	}).disableSelection();
	$("#previewsubmit").click(function() {
		$('#infieldorder').val($('#sortable1.connectedSortable li').map(function() {
			return $(this).text();
		} ).get().join(','));
		$('#outfieldorder').val($('#sortable2.connectedSortable li').map(function() {
			return $(this).text();
		} ).get().join(','));
	});
});
</script>

<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>Fait_groupement exporter</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<p>Utilisez le formulaire ci-dessous pour exporter un fichier CSV.</p>
			<?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>			<?php echo CHtml::hiddenField('action', 'export'); ?>			<?php echo CHtml::hiddenField('infieldorder', $infieldorder); ?>			<?php echo CHtml::hiddenField('outfieldorder', $outfieldorder); ?>			<?php echo CHtml::checkBox('firstline', $firstline, array('id' => 'firstline')); ?>Add column titles on first line
			<?php echo CHtml::submitButton('Preview CSV file', array('id' => 'previewsubmit')); ?>			<?php echo CHtml::submitButton('Export CSV file', array('id' => 'exportsubmit')); ?>			<p>Arrangez les colonnes de gauche de façon à représenter le contenu du fichier CSV</p>
			<p>La colonne de droite contient les champs inutilisés</p>
			<div id="exportcolchooser">
				<ul id="sortable1" class="connectedSortable">
					<?php foreach (split(',', $infieldorder) as $col) { ?>					<li class="ui-state-default"><?php echo $col; ?></li>
					<?php } ?>				</ul>
				<ul id="sortable2" class="connectedSortable">
					<?php foreach (split(',', $outfieldorder) as $col) { ?>					<li class="ui-state-highlight"><?php echo $col; ?></li>
					<?php } ?>				</ul>
			</div><!-- End demo -->
			<?php echo CHtml::endForm(); ?>		</div>
	</div>
</div>
<div class="clear"></div>
<div class="grid_16 widget first">
	<div class="widget_title clearfix"><h2>Export previsualization</h2></div>
	<div class="widget_body">
		<div class="widget_content">
			<pre><?php echo $preview; ?></pre>
		</div>
	</div>
</div>
