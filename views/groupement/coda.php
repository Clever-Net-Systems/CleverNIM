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
	'id' => 'groupement-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Groupement_nom">Nom</label>
		<input size="60" name="Groupement_nom" id="Groupement_nom" type="text" value="<?php echo $groupement->nom; ?>"></input>
	</div>
         <div class="row">
	    <label for="Groupement_tags">Tags</label>
		<?php echo $groupement->getAlltagss(); ?>         </div>
         <div class="row">
	    <label for="Groupement_faits">Faits</label>
		<?php echo $groupement->getAllfaitss(); ?>         </div>
         <div class="row">
	    <label for="Groupement_tags_auto">Tags Auto</label>
		<?php echo $groupement->getAlltags_autos(); ?>         </div>
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
