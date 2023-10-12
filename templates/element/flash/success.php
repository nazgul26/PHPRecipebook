<script type="text/javascript">
    $(function() {
        <?php if (isset($params['event'])) { ?>
        var flashEvent = jQuery.Event("<?php echo h($params['event']);?>");
        $(document).trigger(flashEvent);
        <?php }?>

        toastr.success('<?php echo h($message);?>');
    });
</script>
