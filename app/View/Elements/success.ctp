
<script type="text/javascript">
    $(function() {
        <?php if (isset($event)) { ?>
        var flashEvent = jQuery.Event("<?php echo h($event);?>");
        $(document).trigger(flashEvent);
        <?php } ?>
        $('.notice .success').delay(5000).fadeOut(400);
    });
</script>

<span class="notice success">
<?php echo h($message); ?>
</span>