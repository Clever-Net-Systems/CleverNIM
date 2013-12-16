<strong>Hostname</strong><p><?php echo $poste->hostname; ?></p>
<strong>Puppet name</strong><p><?php echo $poste->nom_puppet; ?></p>
<strong>Serial number</strong><p><?php echo $poste->numero_de_serie; ?></p>
<strong>Router</strong><p><?php echo $poste->routeur; ?></p>
<strong>Creation date</strong><p><?php echo $poste->creation; ?></p>
<strong>Last contact date</strong><p><?php echo $poste->contact; ?></p>
<strong>Tags</strong>
<p>
  <ul>
<?php foreach ($poste->tags as $tag) { echo "<li>" . $tag->_intname . "</li>"; } ?>
  </ul>
</p>
