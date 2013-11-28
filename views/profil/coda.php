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
	'id' => 'profil-form',
	'enableAjaxValidation' => false,
)); ?>


         <div class="row">
	    <label for="Profil_ecoles">Ecoles</label>
		<?php echo $form->listBox($profil, "ecoles", CHtml::listData(Ecole::model()->findAll(), "id", "_intname"), array("multiple" => "multiple")); ?>         </div>
         <div class="row">
	    <label for="Profil_groupements">Groupements</label>
		<?php echo $form->listBox($profil, "groupements", CHtml::listData(Groupement::model()->findAll(), "id", "_intname"), array("multiple" => "multiple")); ?>         </div>
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
