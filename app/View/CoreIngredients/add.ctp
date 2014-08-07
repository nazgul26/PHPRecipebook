<div class="coreIngredients form">
<?php echo $this->Form->create('CoreIngredient'); ?>
	<fieldset>
		<legend><?php echo __('Add Core Ingredient'); ?></legend>
	<?php
		echo $this->Form->input('groupNumber');
		echo $this->Form->input('description');
		echo $this->Form->input('short_description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Core Ingredients'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Ingredients'), array('controller' => 'ingredients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ingredient'), array('controller' => 'ingredients', 'action' => 'add')); ?> </li>
	</ul>
</div>
