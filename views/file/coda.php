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
	'id' => 'file-form',
	'enableAjaxValidation' => false,
)); ?>


	<div class="row">
		<label for="File_filename">filename</label>
		<input size="60" name="File_filename" id="File_filename" type="text" value="<?php echo $file->filename; ?>"></input>
	</div>
         <div class="row">
	    <label for="File_size">Size</label>
	    <input size="60" name="File_size" id="File_size" type="text" value="<?php echo $file->size; ?>"></input>
         </div>
         <div class="row">
	    <label for="File_cdate">Upload date</label>
	    <input size="60" name="File_cdate" id="File_cdate" type="text" value="<?php echo $file->cdate; ?>"></input>
         </div>
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
