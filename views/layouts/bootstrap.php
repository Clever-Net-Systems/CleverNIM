<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto /*-60px*/;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }



      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      #wrap > .container {
        /*padding-top: 60px;*/
      }
      .container .credit {
        margin: 20px 0;
      }

      code {
        font-size: 80%;
      }

    </style>
</head>

<body>
<div id="wrap">
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
			'type' => 'inverse',
			'items'=> array(
				array(
					'class'=>'bootstrap.widgets.TbMenu',
					'items'=> array(
						array('label'=>'Postes', 'url'=>array('/poste/admin'), 'visible' => Yii::app()->user->checkAccess('Node_ViewAll') || Yii::app()->user->checkAccess('Node_ViewGroup')),
						array('label'=>'Tags', 'url'=>array('/tag/admin'), 'visible' => Yii::app()->user->checkAccess('Tag_ViewAll') || Yii::app()->user->checkAccess('Tag_ViewGroup')),
						array('label'=>'Tags automatiques', 'url'=>array('/tagauto/admin'), 'visible' => Yii::app()->user->checkAccess('AutoTag_ViewAll') || Yii::app()->user->checkAccess('AutoTag_ViewGroup')),
						array('label'=>'Inventaire', 'url'=>array('/inventaire/admin'), 'visible' => Yii::app()->user->checkAccess('Inventory_ViewAll') || Yii::app()->user->checkAccess('Inventory_ViewGroup')),
						array('label'=>'Types de tags', 'url'=>array('/typetag/admin'), 'visible' => Yii::app()->user->checkAccess('TagType_ViewAll') || Yii::app()->user->checkAccess('TagType_ViewGroup')),
						array('label'=>'Groupements', 'url'=>array('/groupement/admin'), 'visible' => Yii::app()->user->checkAccess('Group_View')),
						array('label' => 'Admin', 'url' => '#', 'visible' => Yii::app()->user->checkAccess('AppAdmin'), 'items' => array(
								array('label' => 'Gestion des utilisateurs', 'url' => '/user/admin'),
								array('label' => 'Gestion des droits', 'url' => '#', 'items' => array(
										array('label' => 'Assignations', 'url' => '/rights/assignment/view'),
										array('label' => 'Permissions', 'url' => '/rights/authItem/permissions'),
										array('label' => 'Rôles', 'url' => '/rights/authItem/roles'),
										array('label' => 'Tâches', 'url' => '/rights/authItem/tasks'),
										array('label' => 'Opérations', 'url' => '/rights/authItem/operations'),
										)),
								array('label' => 'Logs', 'url' => '/auditTrail/auditAdmin'),
								'---',
								array('label' => 'Outils'),
								array('label' => 'Media Manager', 'url' => '/mediaManager/'),
								array('label' => 'Regeneration inventaire', 'url' => '/inventaire/generate'),
								array('label' => 'Regeneration datawarehouse', 'url' => '/bi/generate'),
								array('label' => 'Synchronisation des manifests', 'url' => '/site/syncmanifests'),
								array('label' => 'Options de recherche', 'url' => '/site/searchoptions'),
								'---',
								array('label' => 'Analyse'),
								array('label' => 'Analyse des donnees', 'url' => '/bi/olap'),
								array('label' => 'Stats PuppetDB', 'url' => '/site/puppetdb'),
								)),
					     ),
					),
					'<form class="navbar-search pull-left" action="/site/search"><input name="q" type="text" class="search-query span2" placeholder="Search"></form>',
					array(
						'class'=>'bootstrap.widgets.TbMenu',
						'htmlOptions'=>array('class'=>'pull-right'),
						'items'=> array(
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
						),
					),
				),
)); ?>
	<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		/*'alerts'=>array( // configurations per alert type
			'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
			'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
			'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
		),*/
	)
); ?>

	<?php echo $content; ?>

	<div class="clear"></div>
	</div><!-- page -->
</div>

<div id="footer">
	<div class="container">
		<p class="muted credit">&copy; DIP / SEM Logistique 2012-2013.</p>
	</div>
</div>
</body>
</html>
