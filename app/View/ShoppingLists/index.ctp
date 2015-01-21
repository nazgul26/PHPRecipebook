<div class="shoppingListNames index">
	<h2><?php echo __('Shopping Lists'); ?></h2>
        <div class="actions">
            <ul>
                    <li><?php echo $this->Html->link(__('New Shopping List'), array('action' => 'edit')); ?></li>
            </ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($shoppingLists as $shoppingList): ?>
	<tr>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $shoppingList['ShoppingList']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $shoppingList['ShoppingList']['id']), 
                            null, __('Are you sure you want to delete # %s?', $shoppingList['ShoppingList']['id'])); ?>
            </td>
            <td><?php echo h($shoppingList['ShoppingList']['name']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

