<div class="shoppingLists view">
<h2><?php echo __('Shopping List Name'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($shoppingList['ShoppingList']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($shoppingList['ShoppingList']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($shoppingList['User']['name'], 
                                array('controller' => 'users', 'action' => 'view', $shoppingList['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Shopping List Name'), array('action' => 'edit', $shoppingList['ShoppingList']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Shopping List Name'), array('action' => 'delete', $shoppingList['ShoppingList']['id']), null, 
                        __('Are you sure you want to delete # %s?', $shoppingList['ShoppingList']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Shopping List Names'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shopping List Name'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shopping List Ingredients'), array('controller' => 'shopping_list_ingredients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shopping List Ingredient'), array('controller' => 'shopping_list_ingredients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shopping List Recipes'), array('controller' => 'shopping_list_recipes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shopping List Recipe'), array('controller' => 'shopping_list_recipes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Shopping List Ingredients'); ?></h3>
	<?php if (!empty($shoppingList['ShoppingListIngredient'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Shopping List Name Id'); ?></th>
		<th><?php echo __('Ingredient Id'); ?></th>
		<th><?php echo __('Unit Id'); ?></th>
		<th><?php echo __('Qualifier'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Sort Order'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($shoppingList['ShoppingListIngredient'] as $shoppingListIngredient): ?>
		<tr>
			<td><?php echo $shoppingListIngredient['shopping_list_name_id']; ?></td>
			<td><?php echo $shoppingListIngredient['ingredient_id']; ?></td>
			<td><?php echo $shoppingListIngredient['unit_id']; ?></td>
			<td><?php echo $shoppingListIngredient['qualifier']; ?></td>
			<td><?php echo $shoppingListIngredient['quantity']; ?></td>
			<td><?php echo $shoppingListIngredient['sort_order']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shopping_list_ingredients', 'action' => 'view', $shoppingListIngredient['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shopping_list_ingredients', 'action' => 'edit', $shoppingListIngredient['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'shopping_list_ingredients', 'action' => 'delete', $shoppingListIngredient['id']), null, __('Are you sure you want to delete # %s?', $shoppingListIngredient['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Shopping List Ingredient'), array('controller' => 'shopping_list_ingredients', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Shopping List Recipes'); ?></h3>
	<?php if (!empty($shoppingList['ShoppingListRecipe'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Shopping List Name Id'); ?></th>
		<th><?php echo __('Recipe Id'); ?></th>
		<th><?php echo __('Scale'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($shoppingList['ShoppingListRecipe'] as $shoppingListRecipe): ?>
		<tr>
			<td><?php echo $shoppingListRecipe['shopping_list_name_id']; ?></td>
			<td><?php echo $shoppingListRecipe['recipe_id']; ?></td>
			<td><?php echo $shoppingListRecipe['scale']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shopping_list_recipes', 'action' => 'view', $shoppingListRecipe['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shopping_list_recipes', 'action' => 'edit', $shoppingListRecipe['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'shopping_list_recipes', 'action' => 'delete', $shoppingListRecipe['id']), null, __('Are you sure you want to delete # %s?', $shoppingListRecipe['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Shopping List Recipe'), array('controller' => 'shopping_list_recipes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
