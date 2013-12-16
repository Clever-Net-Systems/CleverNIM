<strong>Groupement</strong><p><?php echo $tag->groupement->nom; ?></p>
<strong>Valeurs</strong>
<p>
  <ul>
<?php foreach ($tag->valeurs as $valeur) { echo "<li>" . $valeur->parametre->nom . ": " . $valeur->valeur . "</li>"; }; ?>
  </ul>
</p>
