<div class="mealPlans index">
	<h2><?php echo __('Meal Plans'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('mealday'); ?></th>
			<th><?php echo $this->Paginator->sort('meal_name_id'); ?></th>
			<th><?php echo $this->Paginator->sort('recipe_id'); ?></th>
			<th><?php echo $this->Paginator->sort('servings'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($mealPlans as $mealPlan): ?>
	<tr>
		<td><?php echo h($mealPlan['MealPlan']['id']); ?>&nbsp;</td>
		<td><?php echo h($mealPlan['MealPlan']['mealday']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mealPlan['MealName']['name'], array('controller' => 'meal_names', 'action' => 'view', $mealPlan['MealName']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($mealPlan['Recipe']['name'], array('controller' => 'recipes', 'action' => 'view', $mealPlan['Recipe']['id'])); ?>
		</td>
		<td><?php echo h($mealPlan['MealPlan']['servings']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mealPlan['User']['name'], array('controller' => 'users', 'action' => 'view', $mealPlan['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $mealPlan['MealPlan']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $mealPlan['MealPlan']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $mealPlan['MealPlan']['id']), null, __('Are you sure you want to delete # %s?', $mealPlan['MealPlan']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Meal Plan'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Meal Names'), array('controller' => 'meal_names', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Name'), array('controller' => 'meal_names', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recipes'), array('controller' => 'recipes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipe'), array('controller' => 'recipes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
