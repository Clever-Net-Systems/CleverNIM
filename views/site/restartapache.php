<?php
$this->pageTitle='Redémarrage Apache';
$this->breadcrumbs=array(
	'Redémarrage Apache',
);

?>

    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Redémarrage Apache</h2>
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

	<p class="note">Appuyer sur Redémarrer pour relancer Apache sur tous les noeuds du cluster Puppet.</p>

<?php if ($output !== "") { ?>
	<code style="text-align:left;">
	<?php echo implode("<br>\n", $output); ?>
	</code>
<?php } ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Redémarrer'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

	</div>
    </div>
