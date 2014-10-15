
<script type="text/javascript">
    $(function() {
        <?php if (isset($event)) { ?>
        var flashEvent = jQuery.Event("<?php echo h($event);?>");
        $(document).trigger(flashEvent);
        <?php } ?>
    });
</script>

<span class="notice success">
<?php echo h($message); ?>
</span>