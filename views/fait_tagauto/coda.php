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
	'id' => 'fait_tagauto-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Fait_tagauto_fact">Fact</label>
		<input size="60" name="Fait_tagauto_fact" id="Fait_tagauto_fact" type="text" value="<?php echo $fait_tagauto->fact; ?>"></input>
	</div>
	<div class="row">
		<label for="Fait_tagauto_valeur">Valeur</label>
		<input size="60" name="Fait_tagauto_valeur" id="Fait_tagauto_valeur" type="text" value="<?php echo $fait_tagauto->valeur; ?>"></input>
	</div>
	<div class="row">
		<label for="Fait_tagauto_operateur">Operateur</label>
		<input size="60" name="Fait_tagauto_operateur" id="Fait_tagauto_operateur" type="text" value="<?php echo Fait_tagauto::getOperateur_values($fait_tagauto->operateur); ?>"></input>
	</div>
         <div class="row">
	    <label for="Fait_tagauto_tag">Tag</label>
		<?php echo $form->dropDownList($fait_tagauto,"tag_id", CHtml::listData(Tagauto::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>         </div>
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
