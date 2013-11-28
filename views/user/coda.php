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
         <div class="row">
            <label for="User_username">Nom d'utilisateur</label>
            <input size="60" name="User_username" id="User_username" type="text" value="<?php echo $user->username; ?>"></input>
         </div>
         <div class="row">
            <label for="User_email">Email</label>
            <input size="60" name="User_email" id="User_email" type="text" value="<?php echo $user->email; ?>"></input>
         </div>
         <div class="row">
            <label for="User_createtime">Date d'enregistrement</label>
            <input size="60" name="User_createtime" id="User_createtime" type="text" value="<?php echo date("d.m.Y H:i:s", $user->createtime); ?>"></input>
         </div>
         <div class="row">
            <label for="User_lastvisit">Dernière visite</label>
	    <input size="60" name="User_lastvisit" id="User_lastvisit" type="text" value="<?php echo date("d.m.Y H:i:s", $user->lastvisit); ?>"></input>
         </div>
         <div class="row">
            <label for="User_status">Statut</label>
            <input size="60" name="User_status" id="User_status" type="text" value="<?php echo ($user->status == 1) ? "Actif" : (($user->status == 0) ? "Inactif" : "Banni"); ?>"></input>
         </div>
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
