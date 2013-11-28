<?php
$this->pageTitle = Yii::t('app', 'Import Groupement records');
$this->breadcrumbs = array(
	Yii::t('app', 'Import Groupement records'),
);
?>

<style>
#sortable1, #sortable2 { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: left; margin-right: 10px; }
#sortable1 li, #sortable2 li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px; }
#importcolchooser {
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

<div class="bloc_head_arrondi">
	<div class="titre_bloc">Groupement importer</div>
	<div class="content_bloc" style="display: block;">
		<p>Utilisez le formulaire ci-dessous pour importer un fichier CSV.</p>
		<?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>
		<?php echo CHtml::hiddenField('action', 'import'); ?>
		<?php echo CHtml::hiddenField('infieldorder', $infieldorder); ?>
		<?php echo CHtml::hiddenField('outfieldorder', $outfieldorder); ?>
		<?php echo CHtml::fileField('csvfile'); ?>
		<?php echo CHtml::checkBox('discardfirstline', $discardfirstline, array('id' => 'discardfirstline')); ?>Discard first line<br />
		Delimiter <?php echo CHtml::textField('delimiter', $delimiter, array('style' => 'width: 20px;')); ?>
		Enclosure <?php echo CHtml::textField('enclosure', $enclosure, array('style' => 'width: 20px;')); ?>
		Newline <?php echo CHtml::textField('newline', $newline, array('style' => 'width: 20px;')); ?><br />
		<?php echo CHtml::submitButton('Preview CSV file', array('id' => 'previewsubmit')); ?>
		<?php echo CHtml::submitButton('Import CSV file', array('id' => 'importsubmit')); ?>
		<p>Arrangez les colonnes de gauche de façon à représenter le contenu du fichier CSV</p>
		<p>La colonne de droite contient les champs inutilisés</p>
		<div id="importcolchooser">
			<ul id="sortable1" class="connectedSortable">
				<?php foreach (split(',', $infieldorder) as $col) { ?>
				<li class="ui-state-default"><?php echo $col; ?></li>
				<?php } ?>
			</ul>
			<ul id="sortable2" class="connectedSortable">
				<?php foreach (split(',', $outfieldorder) as $col) { ?>
				<li class="ui-state-highlight"><?php echo $col; ?></li>
				<?php } ?>
			</ul>
		</div><!-- End demo -->
		<?php echo CHtml::endForm(); ?>
	</div>
</div>

<div class="bloc_head_arrondi">
	<div class="titre_bloc">Import previsualization</div>
	<div class="content_bloc" style="display: block;">
		<?php if ($infieldorder != '') { $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'groupement-grid',
	'cssFile' => Yii::app()->baseUrl . '/css/ccgridview.css',
	'template' => "{items}\n{summary}",
	'dataProvider' => $preview,
	'emptyText' => Yii::t('app', 'Pas de résultats'),
	'summaryText' => Yii::t('app', 'Résultats {start}-{end} sur {count}.'),
	'columns' => explode(',', $infieldorder),
	)); } ?>	</div>
</div>
