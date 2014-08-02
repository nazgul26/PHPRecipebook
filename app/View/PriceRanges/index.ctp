<div class="priceRanges index">
	<h2><?php echo __('Price Ranges'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($priceRanges as $priceRange): ?>
	<tr>
		<td><?php echo h($priceRange['PriceRange']['id']); ?>&nbsp;</td>
		<td><?php echo h($priceRange['PriceRange']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $priceRange['PriceRange']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $priceRange['PriceRange']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $priceRange['PriceRange']['id']), null, __('Are you sure you want to delete # %s?', $priceRange['PriceRange']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Price Range'), array('action' => 'add')); ?></li>
	</ul>
</div>
