<?php foreach ($tagparams as $tagparam) { ?>
  <a class="tplink" data-trigger='hover' data-title="<?php echo $tagparam->_intname; ?>" data-content="<?php echo CHtml::encode($this->renderPartial('application.views.tagparam.coda', array('tagparam' => $tagparam), true));?>" rel='popover'>
    <?php echo $tagparam->_intname; ?>
  </a><br />
<?php } ?>
<script>$(function() { $(".tplink").popover({ html: true }); });</script>
