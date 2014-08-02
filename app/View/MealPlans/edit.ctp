<div class="mealPlans form">
<?php echo $this->Form->create('MealPlan'); ?>
	<fieldset>
		<legend><?php echo __('Edit Meal Plan'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('mealday');
		echo $this->Form->input('meal_name_id');
		echo $this->Form->input('recipe_id');
		echo $this->Form->input('servings');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('MealPlan.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('MealPlan.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Meal Plans'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Meal Names'), array('controller' => 'meal_names', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Name'), array('controller' => 'meal_names', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recipes'), array('controller' => 'recipes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipe'), array('controller' => 'recipes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
