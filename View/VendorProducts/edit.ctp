<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Online Grocery Vendors '), array('controller'=>'Vendors', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
    <li><?php echo $this->Html->link(__('Products'), array('action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
    <li class="active"><?php echo __('Add & Edit');?></li>
</ol>
<div class="vendorProducts form">
<?php echo $this->Form->create('VendorProduct'); ?>
	<fieldset>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->input('name');
		echo $this->Form->input('ingredient_id');
		echo $this->Form->input('vendor_id');
		echo $this->Form->input('code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
