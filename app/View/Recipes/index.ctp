<?php echo $this->Session->flash(); ?>
<div class="recipes index">
	<h2><?php echo __('Recipes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('comments'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($recipes as $recipe): ?>
	<tr>
		<td><?php echo h($recipe['Recipe']['name']); ?>&nbsp;</td>
		<td><?php echo h($recipe['Recipe']['comments']); ?>&nbsp;</td>
		<td>
                    <?php echo $this->Html->link($recipe['User']['name'], array('controller' => 'users', 'action' => 'view', $recipe['User']['id'])); ?>
		</td>
		<td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $recipe['Recipe']['id']), array('class' => 'ajaxLink')); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recipe['Recipe']['id']), array('class' => 'ajaxLink')); ?>
                    <?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $recipe['Recipe']['id']), array('class' => 'ajaxDeleteLink', 'deleteMessage' => "Are you sure you wish to delete this recipe?")); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('class' => 'ajaxLink'), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','class'=>'ajaxLink'));
		echo $this->Paginator->next(__('next') . ' >', array('class' => 'ajaxLink'), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Recipe'), array('action' => 'add')); ?></li>
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
