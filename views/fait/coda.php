<table width="" border="0" cellspacing="0" cellpadding="0" align="center" class="codaPopupPopup">
<tr>
   <td class="corner topLeft"></td>
   <td class="top"></td>
   <td class="corner topRight"></td>
</tr>
<tr>
   <td class="codaleft">&nbsp;</td>
   <td><div id="codaPopupContent">
      <div class="wide form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'fait-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Fait_fact">Fact</label>
		<input size="60" name="Fait_fact" id="Fait_fact" type="text" value="<?php echo Fait::getFact_values($fait->fact); ?>"></input>
	</div>
	<div class="row">
		<label for="Fait_valeur">Valeur</label>
		<input size="60" name="Fait_valeur" id="Fait_valeur" type="text" value="<?php echo $fait->valeur; ?>"></input>
	</div>
	<div class="row">
		<label for="Fait_operateur">Operateur</label>
		<input size="60" name="Fait_operateur" id="Fait_operateur" type="text" value="<?php echo Fait::getOperateur_values($fait->operateur); ?>"></input>
	</div>
         <div class="row">
	    <label for="Fait_selection">Selection</label>
		<?php echo $form->dropDownList($fait,"selection_id", CHtml::listData(Selection::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>         </div>
            <?php $this->endWidget(); ?>
         </div><!-- form -->
      </div>
   </div></td>
   <td class="codaright">&nbsp;</td>
</tr>
<tr>
   <td class="corner bottomLeft">&nbsp;</td>
   <td class="bottom">&nbsp;</td>
   <td class="corner bottomRight"></td>
</tr>
</table>
