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
	'id' => 'selection-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Selection_operateur">operateur</label>
		<input size="60" name="Selection_operateur" id="Selection_operateur" type="text" value="<?php echo Selection::getOperateur_values($selection->operateur); ?>"></input>
	</div>
	<div class="row">
		<label for="Selection_description">Description</label>
		<input size="60" name="Selection_description" id="Selection_description" type="text" value="<?php echo $selection->description; ?>"></input>
	</div>
         <div class="row">
	    <label for="Selection_faits">Faits</label>
		<?php echo $selection->getAllfaitss(); ?>         </div>
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
