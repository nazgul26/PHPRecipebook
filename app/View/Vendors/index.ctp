<div class="vendors index">
	<h2><?php echo __('Vendors'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('home_url'); ?></th>
			<th><?php echo $this->Paginator->sort('add_url'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($vendors as $vendor): ?>
	<tr>
		<td><?php echo h($vendor['Vendor']['id']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['name']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['home_url']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['add_url']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $vendor['Vendor']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $vendor['Vendor']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $vendor['Vendor']['id']), null, __('Are you sure you want to delete # %s?', $vendor['Vendor']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Vendor'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vendor Products'), array('controller' => 'vendor_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor Product'), array('controller' => 'vendor_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
