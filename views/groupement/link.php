<?php foreach ($groupements as $groupement) { ?>
  <a class="grlink" data-trigger='hover' data-title="<?php echo $groupement->_intname; ?>" data-content="<?php echo CHtml::encode($this->renderPartial('application.views.groupement.coda', array('groupement' => $groupement), true));?>" rel='popover'>
    <?php echo $groupement->_intname; ?>
  </a><br />
<?php } ?>
<script>$(function() { $(".grlink").popover({ html: true }); });</script>
