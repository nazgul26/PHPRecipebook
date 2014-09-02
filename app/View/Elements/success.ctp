<?php if (isset($event)) { ?>
<script type="text/javascript">
var flashEvent = jQuery.Event("<?php echo h($event);?>");
$(document).trigger(flashEvent);
</script>
<?php } ?>
<span class="notice success">
<?php echo h($message); ?>
</span>