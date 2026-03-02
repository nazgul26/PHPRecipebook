<script type="text/javascript">
    onAppReady(function() {
        <?php if (isset($params['event'])) { ?>
        document.dispatchEvent(new CustomEvent("<?= h($params['event']) ?>"));
        <?php }?>

        showToast('<?= h($message) ?>');
    });
</script>
