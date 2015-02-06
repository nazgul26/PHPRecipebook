<div class="vendors view">
<h2><?php echo __('Vendor'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Home Url'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['home_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Add Url'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['add_url']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vendor'), array('action' => 'edit', $vendor['Vendor']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vendor'), array('action' => 'delete', $vendor['Vendor']['id']), null, __('Are you sure you want to delete # %s?', $vendor['Vendor']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Vendors'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vendor Products'), array('controller' => 'vendor_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor Product'), array('controller' => 'vendor_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Vendor Products'); ?></h3>
	<?php if (!empty($vendor['VendorProduct'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Ingredient Id'); ?></th>
		<th><?php echo __('Vendor Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($vendor['VendorProduct'] as $vendorProduct): ?>
		<tr>
			<td><?php echo $vendorProduct['id']; ?></td>
			<td><?php echo $vendorProduct['name']; ?></td>
			<td><?php echo $vendorProduct['ingredient_id']; ?></td>
			<td><?php echo $vendorProduct['vendor_id']; ?></td>
			<td><?php echo $vendorProduct['code']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'vendor_products', 'action' => 'view', $vendorProduct['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'vendor_products', 'action' => 'edit', $vendorProduct['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'vendor_products', 'action' => 'delete', $vendorProduct['id']), null, __('Are you sure you want to delete # %s?', $vendorProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Vendor Product'), array('controller' => 'vendor_products', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
