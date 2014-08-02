<div class="recipes form">
<?php echo $this->Form->create('Recipe'); ?>
	<fieldset>
		<legend><?php echo __('Edit Recipe'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('ethnicity_id');
		echo $this->Form->input('base_type_id');
		echo $this->Form->input('course_id');
		echo $this->Form->input('preparation_time_id');
		echo $this->Form->input('difficulty_id');
		echo $this->Form->input('serving_size');
		echo $this->Form->input('directions');
		echo $this->Form->input('comments');
		echo $this->Form->input('source_id');
		echo $this->Form->input('source_description');
		echo $this->Form->input('picture');
		echo $this->Form->input('picture_type');
		echo $this->Form->input('private');
		echo $this->Form->input('system');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Recipe.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Recipe.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Recipes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Ethnicities'), array('controller' => 'ethnicities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ethnicity'), array('controller' => 'ethnicities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Base Types'), array('controller' => 'base_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Base Type'), array('controller' => 'base_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course'), array('controller' => 'courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Preparation Times'), array('controller' => 'preparation_times', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Preparation Time'), array('controller' => 'preparation_times', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Difficulties'), array('controller' => 'difficulties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Difficulty'), array('controller' => 'difficulties', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Source'), array('controller' => 'sources', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
