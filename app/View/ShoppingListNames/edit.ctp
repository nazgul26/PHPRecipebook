<div class="shoppingListNames form">
<?php echo $this->Form->create('ShoppingListName'); ?>
	<fieldset>
		<legend><?php echo __('Edit Shopping List Name'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ShoppingListName.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ShoppingListName.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Shopping List Names'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shopping List Ingredients'), array('controller' => 'shopping_list_ingredients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shopping List Ingredient'), array('controller' => 'shopping_list_ingredients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shopping List Recipes'), array('controller' => 'shopping_list_recipes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shopping List Recipe'), array('controller' => 'shopping_list_recipes', 'action' => 'add')); ?> </li>
	</ul>
</div>
