<?php foreach ($faits as $fait) { ?>
  <a class="tplink" data-trigger='hover' data-title="<?php echo $fait->_intname; ?>" data-content="<?php echo CHtml::encode($this->renderPartial('application.views.fait_groupement.coda', array('fait' => $fait), true));?>" rel='popover'>
    <?php echo $fait->_intname; ?>
  </a><br />
<?php } ?>
<script>$(function() { $(".tplink").popover({ html: true }); });</script>
