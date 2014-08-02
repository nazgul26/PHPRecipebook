<div class="units view">
<h2><?php echo __('Unit'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($unit['Unit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($unit['Unit']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Abbreviation'); ?></dt>
		<dd>
			<?php echo h($unit['Unit']['abbreviation']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd>
			<?php echo h($unit['Unit']['system']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sort Order'); ?></dt>
		<dd>
			<?php echo h($unit['Unit']['sort_order']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Unit'), array('action' => 'edit', $unit['Unit']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Unit'), array('action' => 'delete', $unit['Unit']['id']), null, __('Are you sure you want to delete # %s?', $unit['Unit']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Units'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Unit'), array('action' => 'add')); ?> </li>
	</ul>
</div>
