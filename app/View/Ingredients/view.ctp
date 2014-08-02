<div class="ingredients view">
<h2><?php echo __('Ingredient'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ingredient['Ingredient']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Core Ingredient'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ingredient['CoreIngredient']['description'], array('controller' => 'core_ingredients', 'action' => 'view', $ingredient['CoreIngredient']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($ingredient['Ingredient']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($ingredient['Ingredient']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ingredient['Location']['name'], array('controller' => 'locations', 'action' => 'view', $ingredient['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Unit'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ingredient['Unit']['name'], array('controller' => 'units', 'action' => 'view', $ingredient['Unit']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Solid'); ?></dt>
		<dd>
			<?php echo h($ingredient['Ingredient']['solid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd>
			<?php echo h($ingredient['Ingredient']['system']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ingredient['User']['name'], array('controller' => 'users', 'action' => 'view', $ingredient['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ingredient'), array('action' => 'edit', $ingredient['Ingredient']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ingredient'), array('action' => 'delete', $ingredient['Ingredient']['id']), null, __('Are you sure you want to delete # %s?', $ingredient['Ingredient']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ingredients'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ingredient'), array('action' => 'add')); ?> </li>
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
