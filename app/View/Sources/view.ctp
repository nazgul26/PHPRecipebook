<div class="sources view">
<h2><?php echo __('Source'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($source['Source']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($source['Source']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($source['Source']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($source['User']['name'], array('controller' => 'users', 'action' => 'view', $source['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Source'), array('action' => 'edit', $source['Source']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Source'), array('action' => 'delete', $source['Source']['id']), null, __('Are you sure you want to delete # %s?', $source['Source']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sources'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Source'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
