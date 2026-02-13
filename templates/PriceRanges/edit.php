<script type="text/javascript">
    (function() {
        var submitEl = document.querySelector('.priceRanges .submit');
        if (submitEl) submitEl.classList.add('d-none');
    })();
</script>
<div class="priceRanges form">
<?= $this->Form->create($priceRange, array('default' => false, 'targetId' => 'editPriceRangesDialog')) ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Flash->render() ?>
