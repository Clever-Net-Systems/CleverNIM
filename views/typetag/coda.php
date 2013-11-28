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
	'id' => 'typetag-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Typetag_nom">Nom</label>
		<input size="60" name="Typetag_nom" id="Typetag_nom" type="text" value="<?php echo $typetag->nom; ?>"></input>
	</div>
	<div class="row">
		<label for="Typetag_classe">Classe</label>
		<input size="60" name="Typetag_classe" id="Typetag_classe" type="text" value="<?php echo $typetag->classe; ?>"></input>
	</div>
         <div class="row">
	    <label for="Typetag_tags">Tags</label>
		<?php echo $typetag->getAlltagss(); ?>         </div>
         <div class="row">
	    <label for="Typetag_parametre">Paramètre</label>
		<?php echo $typetag->getAllparametres(); ?>         </div>
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
