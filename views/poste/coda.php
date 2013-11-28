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
	'id' => 'poste-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="Poste_hostname">Hostname</label>
		<input size="60" name="Poste_hostname" id="Poste_hostname" type="text" value="<?php echo $poste->hostname; ?>"></input>
	</div>
	<div class="row">
		<label for="Poste_nom_puppet">Nom Puppet</label>
		<input size="60" name="Poste_nom_puppet" id="Poste_nom_puppet" type="text" value="<?php echo $poste->nom_puppet; ?>"></input>
	</div>
	<div class="row">
		<label for="Poste_numero_de_serie">Numéro de série</label>
		<input size="60" name="Poste_numero_de_serie" id="Poste_numero_de_serie" type="text" value="<?php echo $poste->numero_de_serie; ?>"></input>
	</div>
	<div class="row">
		<label for="Poste_routeur">routeur</label>
		<input size="60" name="Poste_routeur" id="Poste_routeur" type="text" value="<?php echo $poste->routeur; ?>"></input>
	</div>
         <div class="row">
	    <label for="Poste_date_creation">date_creation</label>
	    <input size="60" name="Poste_date_creation" id="Poste_date_creation" type="text" value="<?php echo $poste->date_creation; ?>"></input>
         </div>
         <div class="row">
	    <label for="Poste_date_contact">date_contact</label>
	    <input size="60" name="Poste_date_contact" id="Poste_date_contact" type="text" value="<?php echo $poste->date_contact; ?>"></input>
         </div>
	<div class="row">
		<label for="Poste_heure_creation">heure_creation</label>
		<input size="60" name="Poste_heure_creation" id="Poste_heure_creation" type="text" value="<?php echo $poste->heure_creation; ?>"></input>
	</div>
	<div class="row">
		<label for="Poste_heure_contact">heure_contact</label>
		<input size="60" name="Poste_heure_contact" id="Poste_heure_contact" type="text" value="<?php echo $poste->heure_contact; ?>"></input>
	</div>
         <div class="row">
	    <label for="Poste_ecole">Ecole</label>
		<?php echo $form->dropDownList($poste,"ecole_id", CHtml::listData(Ecole::model()->findAll(array("order" => "_intname")), "id", "_intname")); ?>         </div>
         <div class="row">
	    <label for="Poste_tags">Tags</label>
		<?php echo $poste->getAlltagss(); ?>         </div>
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
