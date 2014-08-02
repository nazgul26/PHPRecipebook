<div class="restaurants index">
	<h2><?php echo __('Restaurants'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('street'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('zip'); ?></th>
			<th><?php echo $this->Paginator->sort('country'); ?></th>
			<th><?php echo $this->Paginator->sort('phone'); ?></th>
			<th><?php echo $this->Paginator->sort('hours'); ?></th>
			<th><?php echo $this->Paginator->sort('picture'); ?></th>
			<th><?php echo $this->Paginator->sort('picture_type'); ?></th>
			<th><?php echo $this->Paginator->sort('menu_text'); ?></th>
			<th><?php echo $this->Paginator->sort('comments'); ?></th>
			<th><?php echo $this->Paginator->sort('price_ranges_id'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery'); ?></th>
			<th><?php echo $this->Paginator->sort('carry_out'); ?></th>
			<th><?php echo $this->Paginator->sort('dine_in'); ?></th>
			<th><?php echo $this->Paginator->sort('credit'); ?></th>
			<th><?php echo $this->Paginator->sort('website'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($restaurants as $restaurant): ?>
	<tr>
		<td><?php echo h($restaurant['Restaurant']['id']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['name']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['street']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['city']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['state']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['zip']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['country']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['phone']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['hours']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['picture']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['picture_type']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['menu_text']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['comments']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($restaurant['PriceRanges']['name'], array('controller' => 'price_ranges', 'action' => 'view', $restaurant['PriceRanges']['id'])); ?>
		</td>
		<td><?php echo h($restaurant['Restaurant']['delivery']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['carry_out']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['dine_in']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['credit']); ?>&nbsp;</td>
		<td><?php echo h($restaurant['Restaurant']['website']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($restaurant['User']['name'], array('controller' => 'users', 'action' => 'view', $restaurant['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $restaurant['Restaurant']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $restaurant['Restaurant']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $restaurant['Restaurant']['id']), null, __('Are you sure you want to delete # %s?', $restaurant['Restaurant']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Restaurant'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Price Ranges'), array('controller' => 'price_ranges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Price Ranges'), array('controller' => 'price_ranges', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
