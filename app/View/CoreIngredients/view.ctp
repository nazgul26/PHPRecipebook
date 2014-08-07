<div class="coreIngredients view">
<h2><?php echo __('Core Ingredient'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($coreIngredient['CoreIngredient']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('GroupNumber'); ?></dt>
		<dd>
			<?php echo h($coreIngredient['CoreIngredient']['groupNumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($coreIngredient['CoreIngredient']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Description'); ?></dt>
		<dd>
			<?php echo h($coreIngredient['CoreIngredient']['short_description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Core Ingredient'), array('action' => 'edit', $coreIngredient['CoreIngredient']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Core Ingredient'), array('action' => 'delete', $coreIngredient['CoreIngredient']['id']), null, __('Are you sure you want to delete # %s?', $coreIngredient['CoreIngredient']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Core Ingredients'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Core Ingredient'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ingredients'), array('controller' => 'ingredients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ingredient'), array('controller' => 'ingredients', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Ingredients'); ?></h3>
	<?php if (!empty($coreIngredient['Ingredient'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Unit Id'); ?></th>
		<th><?php echo __('Solid'); ?></th>
		<th><?php echo __('System'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Core Ingredient Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($coreIngredient['Ingredient'] as $ingredient): ?>
		<tr>
			<td><?php echo $ingredient['id']; ?></td>
			<td><?php echo $ingredient['name']; ?></td>
			<td><?php echo $ingredient['description']; ?></td>
			<td><?php echo $ingredient['location_id']; ?></td>
			<td><?php echo $ingredient['unit_id']; ?></td>
			<td><?php echo $ingredient['solid']; ?></td>
			<td><?php echo $ingredient['system']; ?></td>
			<td><?php echo $ingredient['user_id']; ?></td>
			<td><?php echo $ingredient['core_ingredient_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'ingredients', 'action' => 'view', $ingredient['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'ingredients', 'action' => 'edit', $ingredient['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'ingredients', 'action' => 'delete', $ingredient['id']), null, __('Are you sure you want to delete # %s?', $ingredient['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ingredient'), array('controller' => 'ingredients', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
