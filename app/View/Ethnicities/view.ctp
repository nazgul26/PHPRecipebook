<div class="ethnicities view">
<h2><?php echo __('Ethnicity'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ethnicity['Ethnicity']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($ethnicity['Ethnicity']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ethnicity'), array('action' => 'edit', $ethnicity['Ethnicity']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ethnicity'), array('action' => 'delete', $ethnicity['Ethnicity']['id']), null, __('Are you sure you want to delete # %s?', $ethnicity['Ethnicity']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ethnicities'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ethnicity'), array('action' => 'add')); ?> </li>
	</ul>
</div>
