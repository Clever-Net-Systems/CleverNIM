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
	'id' => 'tagparam-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Tagparam_nom">Nom</label>
		<input size="60" name="Tagparam_nom" id="Tagparam_nom" type="text" value="<?php echo $tagparam->nom; ?>"></input>
	</div>
	<div class="row">
		<label for="Tagparam_description">Description</label>
		<input size="60" name="Tagparam_description" id="Tagparam_description" type="text" value="<?php echo $tagparam->description; ?>"></input>
	</div>
	<div class="row">
		<label for="Tagparam_type">Type</label>
		<input size="60" name="Tagparam_type" id="Tagparam_type" type="text" value="<?php echo Tagparam::getType_values($tagparam->type); ?>"></input>
	</div>
         <div class="row">
	    <label for="Tagparam_possibles">possibles</label>
	    <input size="60" name="Tagparam_possibles" id="Tagparam_possibles" type="text" value="<?php echo $tagparam->possibles; ?>"></input>
         </div>
         <div class="row">
	    <label for="Tagparam_valeurs">Valeurs</label>
		<?php echo $tagparam->getAllvaleurss(); ?>         </div>
         <div class="row">
	    <label for="Tagparam_type_de_tag">Type de tag</label>
		<?php echo $form->dropDownList($tagparam,"type_de_tag_id", CHtml::listData(Typetag::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>         </div>
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
