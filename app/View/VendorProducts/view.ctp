<div class="vendorProducts view">
<h2><?php echo __('Vendor Product'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($vendorProduct['VendorProduct']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($vendorProduct['VendorProduct']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ingredient'); ?></dt>
		<dd>
			<?php echo $this->Html->link($vendorProduct['Ingredient']['name'], array('controller' => 'ingredients', 'action' => 'view', $vendorProduct['Ingredient']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vendor'); ?></dt>
		<dd>
			<?php echo $this->Html->link($vendorProduct['Vendor']['name'], array('controller' => 'vendors', 'action' => 'view', $vendorProduct['Vendor']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($vendorProduct['VendorProduct']['code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vendor Product'), array('action' => 'edit', $vendorProduct['VendorProduct']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vendor Product'), array('action' => 'delete', $vendorProduct['VendorProduct']['id']), null, __('Are you sure you want to delete # %s?', $vendorProduct['VendorProduct']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Vendor Products'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor Product'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ingredients'), array('controller' => 'ingredients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ingredient'), array('controller' => 'ingredients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vendors'), array('controller' => 'vendors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor'), array('controller' => 'vendors', 'action' => 'add')); ?> </li>
	</ul>
</div>
