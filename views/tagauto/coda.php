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
	'id' => 'tagauto-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Tagauto_nom">Nom</label>
		<input size="60" name="Tagauto_nom" id="Tagauto_nom" type="text" value="<?php echo $tagauto->nom; ?>"></input>
	</div>
	<div class="row">
		<label for="Tagauto_classe">Classe</label>
		<input size="60" name="Tagauto_classe" id="Tagauto_classe" type="text" value="<?php echo $tagauto->classe; ?>"></input>
	</div>
         <div class="row">
	    <label for="Tagauto_faits">Faits</label>
		<?php echo $tagauto->getAllfaitss(); ?>         </div>
         <div class="row">
	    <label for="Tagauto_groupement">Groupement</label>
		<?php echo $form->dropDownList($tagauto,"groupement_id", CHtml::listData(Groupement::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>         </div>
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
