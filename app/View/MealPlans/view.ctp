<div class="mealPlans view">
<h2><?php echo __('Meal Plan'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mealPlan['MealPlan']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mealday'); ?></dt>
		<dd>
			<?php echo h($mealPlan['MealPlan']['mealday']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Meal Name'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mealPlan['MealName']['name'], array('controller' => 'meal_names', 'action' => 'view', $mealPlan['MealName']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Recipe'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mealPlan['Recipe']['name'], array('controller' => 'recipes', 'action' => 'view', $mealPlan['Recipe']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Servings'); ?></dt>
		<dd>
			<?php echo h($mealPlan['MealPlan']['servings']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($mealPlan['User']['name'], array('controller' => 'users', 'action' => 'view', $mealPlan['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Meal Plan'), array('action' => 'edit', $mealPlan['MealPlan']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Meal Plan'), array('action' => 'delete', $mealPlan['MealPlan']['id']), null, __('Are you sure you want to delete # %s?', $mealPlan['MealPlan']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Plans'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Plan'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Names'), array('controller' => 'meal_names', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Name'), array('controller' => 'meal_names', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recipes'), array('controller' => 'recipes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipe'), array('controller' => 'recipes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
