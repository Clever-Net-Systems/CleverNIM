<?php echo CHtml::image($typetag->icone) . "&nbsp;"; ?>
<a class="ttlink" data-trigger='hover' data-title="<?php echo $typetag->_intname; ?>" data-content="<?php echo CHtml::encode($this->renderPartial('application.views.typetag.coda', array('typetag' => $typetag), true));?>" rel='popover'>
  <?php echo $typetag->_intname; ?>
</a>
<script>$(function() { $(".ttlink").popover({ html: true }); });</script>
