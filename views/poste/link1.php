<a class="ndlink" data-trigger='hover' data-title="<?php echo $poste->_intname; ?>" data-content="<?php echo CHtml::encode($this->renderPartial('application.views.poste.coda', array('poste' => $poste), true));?>" rel='popover'>
  <?php echo $poste->_intname; ?>
</a><br />
<script>$(function() { $(".ndlink").popover({ html: true }); });</script>
