<?php
$this->pageTitle='Generation de l\'inventaire';
$this->breadcrumbs=array(
	'Geneération de l\'inventaire',
);

?>

    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Generation de l'inventaire</h2>
	</div>
        <div class="widget_body">
<div class="wide form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'restartapache',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<p class="note">Appuyer sur Generation pour regenerer la base de donnees des inventaires.</p>

<?php if ($output !== "") { ?>
	<code style="text-align:left;">
	<?php echo implode("<br>\n", $output); ?>
	</code>
<?php } ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Generation'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

	</div>
    </div>
