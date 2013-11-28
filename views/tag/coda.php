<strong>Groupement</strong><p><?php echo $tag->groupement->nom; ?></p>
<strong>Postes</strong>
<p>
  <ul>
<?php foreach ($tag->postes as $poste) { echo "<li>" . $poste->_intname . "</li>"; } ?>
  </ul>
</p>
<strong>Valeurs</strong>
<p>
  <ul>
<?php foreach ($tag->valeurs as $valeur) { echo "<li>" . $valeur->parametre->nom . ": " . $valeur->valeur . "</li>"; }; ?>
  </ul>
</p>
