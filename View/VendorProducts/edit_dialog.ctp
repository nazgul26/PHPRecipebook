<script type="text/javascript">
    $(function() {
        $('.vendorProducts .submit').hide();
    });
</script>
<div class="vendorProducts form">
<?php echo $this->Form->create('VendorProduct', array('default' => false, 'targetId' => 'editProductDialog')); ?>
<?php echo $this->Form->create('VendorProduct'); ?>
	<fieldset>
	<?php
		echo $this->Form->hidden('id');
                echo $this->Form->hidden('vendor_id');
		echo $this->Form->input('name');
		echo $this->Form->input('ingredient_id');
		echo $this->Form->input('code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
