<script type="text/javascript">
    $(function() {
        $('.priceRanges .submit').hide();
    });
</script>
<div class="priceRanges form">
<?php echo $this->Form->create($priceRange, array('default' => false, 'targetId' => 'editPriceRangesDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->control('name');
?>
<?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>
