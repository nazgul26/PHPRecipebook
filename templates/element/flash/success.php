<script type="text/javascript">
    (function() {
        <?php if (isset($params['event'])) { ?>
        document.dispatchEvent(new CustomEvent("<?= h($params['event']) ?>"));
        <?php }?>

        showToast('<?= h($message) ?>');
    })();
</script>
