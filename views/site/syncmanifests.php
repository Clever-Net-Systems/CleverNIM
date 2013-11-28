<?php
$this->pageTitle='Synchronisation des manifests';
$this->breadcrumbs=array(
	'Synchronisation des manifests',
);

?>

    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Synchronisation des manifests</h2>
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

	<p class="note">Appuyer sur Synchroniser pour forcer la resynchronisation des manifests sur tous les noeuds du cluster Puppet.</p>

<?php if ($output !== "") { ?>
	<code style="text-align:left;">
	<?php echo implode("<br>\n", $output); ?>
	</code>
<?php } ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Synchroniser'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

	</div>
    </div>
