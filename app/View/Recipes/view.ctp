<div class="recipes view">
<h2><?php echo __('Recipe'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ethnicity'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recipe['Ethnicity']['name'], array('controller' => 'ethnicities', 'action' => 'view', $recipe['Ethnicity']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Base Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recipe['BaseType']['name'], array('controller' => 'base_types', 'action' => 'view', $recipe['BaseType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recipe['Course']['name'], array('controller' => 'courses', 'action' => 'view', $recipe['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Preparation Time'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recipe['PreparationTime']['name'], array('controller' => 'preparation_times', 'action' => 'view', $recipe['PreparationTime']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Difficulty'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recipe['Difficulty']['name'], array('controller' => 'difficulties', 'action' => 'view', $recipe['Difficulty']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Serving Size'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['serving_size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Directions'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['directions']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Source'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recipe['Source']['name'], array('controller' => 'sources', 'action' => 'view', $recipe['Source']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Source Description'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['source_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Picture'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['picture']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Picture Type'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['picture_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Private'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['private']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['system']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recipe['User']['name'], array('controller' => 'users', 'action' => 'view', $recipe['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Recipe'), array('action' => 'edit', $recipe['Recipe']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Recipe'), array('action' => 'delete', $recipe['Recipe']['id']), null, __('Are you sure you want to delete # %s?', $recipe['Recipe']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Recipes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recipe'), array('action' => 'add')); ?> </li>
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
