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
	'id' => 'fait_groupement-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Fait_groupement_fact">Fact</label>
		<input size="60" name="Fait_groupement_fact" id="Fait_groupement_fact" type="text" value="<?php echo $fait_groupement->fact; ?>"></input>
	</div>
	<div class="row">
		<label for="Fait_groupement_valeur">Valeur</label>
		<input size="60" name="Fait_groupement_valeur" id="Fait_groupement_valeur" type="text" value="<?php echo $fait_groupement->valeur; ?>"></input>
	</div>
	<div class="row">
		<label for="Fait_groupement_operateur">operateur</label>
		<input size="60" name="Fait_groupement_operateur" id="Fait_groupement_operateur" type="text" value="<?php echo Fait_groupement::getOperateur_values($fait_groupement->operateur); ?>"></input>
	</div>
         <div class="row">
	    <label for="Fait_groupement_groupement">Groupement</label>
		<?php echo $form->dropDownList($fait_groupement,"groupement_id", CHtml::listData(Groupement::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>         </div>
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
