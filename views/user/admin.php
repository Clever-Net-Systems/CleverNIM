<?php
$this->pageTitle = Yii::t('app', 'Gestion des utilisateurs');
$this->breadcrumbs=array(
	'Gestion des utilisateurs',
);

?>

<?php $controller = $this; $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'user-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $model->search(),
	'afterAjaxUpdate' => 'function() { $(".editable").editable(); }',
	'filter'=>$model,
	'emptyText' => 'Pas de résultats',
	'summaryText' => 'Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href="/user/export"><img src="/images/csv.png" alt="CSV Icon"></a>',
	'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => Yii::t('app', '< Précédent'), 'nextPageLabel' => Yii::t('app', 'Suivant >')),
	'columns'=>array(
		array(
			'class' => 'application.extensions.x-editable.EditableColumn',
			'name' => 'username',
			'headerHtmlOptions' => array('style' => 'width: 110px'),
			'editable' => array(
				'url'        => $this->createUrl('user/updateEditable'),
				'placement'  => 'right',
				'options' => array(
					'mode' => 'inline',
				),
				'params' => array('class' => 'User'),
			)               
		     ),
		array(
			'header'=>Rights::t('core', 'Rôles assignés'),
			'type'=>'raw',
			'value'=>'implode("<br />", array_keys(Rights::getAssignedRoles($data->id)))',
		     ),
//		'email',
//		'lang',
		array(
			'name' => 'Groupements',
			'filter' => false,
			'type' => 'raw',
			'value' => function($data, $row) use ($controller) { return $controller->renderPartial('application.views.groupement.link', array('groupements' => $data->groupements), true); }
		),
		array(
			'name' => 'createtime',
			'value' => 'date("d.m.Y H:i:s",$data->createtime)',
		),
		array(
			'name' => 'lastvisit',
			'value' => 'date("d.m.Y H:i:s",$data->lastvisit)',
		),
/*		array(
			'name' => 'status',
			'filter' => SWHelper::allStatuslistData($model),
			'type' => 'raw',
			'value' => 'CHtml::encode($data->status)'
		),*/
//		'avatar',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => CHtml::dropDownList(
				'pageSize',
				Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				array(10 => 10, 50 => 50, 100 => 100, 200 => 200, 500 => 500),
				array('onchange' => "$.fn.yiiGridView.update('user-grid', { data:{ pageSize: $(this).val() } });", 'style' => 'width: 70px; margin-bottom: 0;')
			),
			'template' => '{update}{del}',
			'buttons' => array(
				'update' => array (
					'label' => Yii::t('app', 'Edition'),
					'url' => 'Yii::app()->createUrl("user/update", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'imageUrl' => Yii::app()->request->baseUrl . '/images/update.png',
				),
				'del' => array (
					'label' => Yii::t('app', '<i class="icon-trash"></i>'),
					'url' => 'Yii::app()->createUrl("user/delete", array("id" => $data->id, "prevUri" => Yii::app()->request->requestUri))',
					'options' => array('class' => 'delete', 'data-original-title' => 'Suppression', 'title' => 'Suppression'),
				),
			),
		),
	),
)); ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-form',
	'type' => 'vertical',
	'action' => Yii::app()->createUrl('user/create'),
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('class' => 'well'),
)); ?>
	<?php echo $form->errorSummary(array($newuser)); ?>
	<?php echo $form->textFieldRow($newuser, 'username', array('size' => 20, 'maxlength' => 20, 'hint' => "L'identifiant de l'utilisateur")); ?>
	<?php echo $form->labelEx($newuser,'password'); ?>
	<?php echo CHtml::activePasswordField($newuser,'password',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->hiddenField($newuser, 'status', array('value' => "active")); ?>
	<?php echo $form->error($newuser,'password'); ?>
	<?php echo $form->textFieldRow($newuser, 'email', array('size' => 60, 'maxlength' => 128, 'hint' => "Email de l'utilisateur")); ?>
	<?php echo $form->labelEx($newuser, 'groupements'); ?>
	<?php echo $form->listBox($newuser, "groupementsIds", CHtml::listData(Groupement::model()->findAll(), "id", "_intname"), array("multiple" => "multiple")); ?>
	<?php echo $form->error($newuser, 'groupements'); ?>
	<p class="hint">Les groupements que ce profil peut administrer</p>
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Ajouter')); ?>
<?php $this->endWidget(); ?>
