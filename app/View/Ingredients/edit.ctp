<div class="ingredients form">
<?php echo $this->Form->create('Ingredient'); ?>
	<fieldset>
		<legend><?php echo __('Edit Ingredient'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('core_ingredient_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('location_id');
		echo $this->Form->input('unit_id');
		echo $this->Form->input('solid');
		echo $this->Form->input('system');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Ingredient.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Ingredient.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Ingredients'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Core Ingredients'), array('controller' => 'core_ingredients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Core Ingredient'), array('controller' => 'core_ingredients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Units'), array('controller' => 'units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Unit'), array('controller' => 'units', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
