<script type="text/javascript">
    $(function() {
        $('.priceRanges .submit').hide();
    });
</script>
<div class="priceRanges form">
<?php echo $this->Form->create('PriceRange', array('default' => false, 'targetId' => 'editPriceRangesDialog')); ?>
<?php
        echo $this->Form->input('id');
        echo $this->Form->input('name');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
