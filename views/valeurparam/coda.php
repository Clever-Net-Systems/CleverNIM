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
	'id' => 'valeurparam-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Valeurparam_valeur">Valeur</label>
		<input size="60" name="Valeurparam_valeur" id="Valeurparam_valeur" type="text" value="<?php echo $valeurparam->valeur; ?>"></input>
	</div>
         <div class="row">
	    <label for="Valeurparam_tag">Tag</label>
		<?php echo $form->dropDownList($valeurparam,"tag_id", CHtml::listData(Tag::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>         </div>
         <div class="row">
	    <label for="Valeurparam_parametre">Parametre</label>
		<?php echo $form->dropDownList($valeurparam,"parametre_id", CHtml::listData(Tagparam::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>         </div>
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
