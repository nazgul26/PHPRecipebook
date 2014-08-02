<div class="preparationTimes view">
<h2><?php echo __('Preparation Time'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($preparationTime['PreparationTime']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($preparationTime['PreparationTime']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Preparation Time'), array('action' => 'edit', $preparationTime['PreparationTime']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Preparation Time'), array('action' => 'delete', $preparationTime['PreparationTime']['id']), null, __('Are you sure you want to delete # %s?', $preparationTime['PreparationTime']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Preparation Times'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Preparation Time'), array('action' => 'add')); ?> </li>
	</ul>
</div>
