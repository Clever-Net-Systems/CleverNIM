<?php
$this->pageTitle='Kick';
$this->breadcrumbs=array(
	'Kick',
);

?>

    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Kick de poste</h2>
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

	<p class="note">Cliquez sur Kicker pour réveiller les agents OCS et Puppet de la machine <?php echo $poste->hostname; ?>.</p>

<?php if ($output !== "") { ?>
	<code style="text-align:left;">
	<?php echo implode("<br>\n", $output); ?>
	</code>
	<p></p>
<?php } ?>

	<div class="row buttons">
		<?php echo CHtml::dropDownList('envaction', 'nomodif', array('nomodif' => 'Pas de modification (' . $env . ')', 'dev' => 'Développement', 'valid' => 'Validation', 'prod' => 'Production')); ?>
		<?php echo CHtml::submitButton('Kicker'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

	</div>
    </div>
