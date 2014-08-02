<div class="difficulties view">
<h2><?php echo __('Difficulty'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($difficulty['Difficulty']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($difficulty['Difficulty']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Difficulty'), array('action' => 'edit', $difficulty['Difficulty']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Difficulty'), array('action' => 'delete', $difficulty['Difficulty']['id']), null, __('Are you sure you want to delete # %s?', $difficulty['Difficulty']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Difficulties'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Difficulty'), array('action' => 'add')); ?> </li>
	</ul>
</div>
