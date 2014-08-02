<div class="shoppingListNames index">
	<h2><?php echo __('Shopping List Names'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($shoppingListNames as $shoppingListName): ?>
	<tr>
		<td><?php echo h($shoppingListName['ShoppingListName']['id']); ?>&nbsp;</td>
		<td><?php echo h($shoppingListName['ShoppingListName']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($shoppingListName['User']['name'], array('controller' => 'users', 'action' => 'view', $shoppingListName['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $shoppingListName['ShoppingListName']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $shoppingListName['ShoppingListName']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $shoppingListName['ShoppingListName']['id']), null, __('Are you sure you want to delete # %s?', $shoppingListName['ShoppingListName']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Shopping List Name'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shopping List Ingredients'), array('controller' => 'shopping_list_ingredients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shopping List Ingredient'), array('controller' => 'shopping_list_ingredients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shopping List Recipes'), array('controller' => 'shopping_list_recipes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shopping List Recipe'), array('controller' => 'shopping_list_recipes', 'action' => 'add')); ?> </li>
	</ul>
</div>
