<?php foreach ($poste->tags as $tag) { ?>
  <a class="taglistitem" style="color: #fff; text-decoration: none;" data-trigger='hover' data-title="<?php echo $tag->_intname; ?>" data-content="<?php echo CHtml::encode($this->renderPartial('application.views.tag.coda', array('tag' => $tag), true));?>" rel='popover'>
    <span class="label label-default">
      <?php echo CHtml::image($tag->type_de_tag->icone); ?>&nbsp;<?php echo $tag->_intname; ?>
    </span>
  </a>
<?php } ?>
<script>$(function() { $(".taglistitem").popover({ html: true }); });</script>
