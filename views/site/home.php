<?php
$this->pageTitle='Home';
$this->breadcrumbs=array(
	'Home',
);
?>

    <div class="grid_16 widget first">
        <div class="widget_title clearfix">
		<h2>Menu principal</h2>
	</div>
	<div class="widget_body">
		<div class="widget_content">
		<h3>Tables</h3>
  <ul class="list-tick">
    <li class=""><a href="/groupement/admin">Groupements</a> - Gestion des groupements permettant de cloisonner l'action des tags</li>
    <li class=""><a href="/poste/admin">Postes</a> - Gestion des postes</li>
    <li class=""><a href="/tag/admin">Tags</a> - Liste des tags</li>
    <li class=""><a href="/tagparam/admin">Paramètres de tags</a>  - N/A</li>
    <li class=""><a href="/typetag/admin">Type de tag</a> - Gestion des tags manuels</li>
    <li class=""><a href="/fait_groupement/admin">Faits de groupements</a> - N/A</li>
    <li class=""><a href="/tagauto/admin">Tags automatiques</a> - Gestion des tags automatiques</li>
    <li class=""><a href="/fait_tagauto/admin">Faits de tags automatiques</a> - N/A</li>
  </ul>
		<br />
		<br />
		<br />
	    	[ <a href="/site/restartapache">Redémarrage Apache sur tout le cluster</a> ]
	    	[ <a href="/site/syncmanifests">Synchroniser les manifests sur tout le cluster</a> ]
		</div>
	</div>
    </div>
