<div class="vendors form">
<?php echo $this->Form->create('Vendor'); ?>
	<fieldset>
		<legend><?php echo __('Add Vendor'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('home_url');
		echo $this->Form->input('add_url');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Vendors'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Vendor Products'), array('controller' => 'vendor_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor Product'), array('controller' => 'vendor_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
