<?php
$this->pageTitle='Generation du datawarehouse';
$this->breadcrumbs=array(
	'Generation du datawarehouse',
);

?>

    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
            <h2>Generation du datawarehouse</h2>
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

	<p class="note">Appuyer sur Generation pour regenerer le datawarehouse.</p>

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
