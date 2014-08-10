<div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('Add Ingredient'), array('action' => 'add'), array('class' => 'ajaxLink', 'targetId' => 'addIngredientDialog'));?></li>
            <li><button id="moreActionLinks">More Actions...</button></li>
	</ul>
        <div style="display: none;">
            <ul id="moreActionLinksContent">
                <li><?php echo $this->Html->link(__('List Core Ingredients'), array('controller' => 'core_ingredients', 'action' => 'index'), array('class' => 'ajaxLink')); ?> </li>
		<li><?php echo $this->Html->link(__('New Core Ingredient'), array('controller' => 'core_ingredients', 'action' => 'add'), array('class' => 'ajaxLink')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index'), array('class' => 'ajaxLink')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add'), array('class' => 'ajaxLink')); ?> </li>
		<li><?php echo $this->Html->link(__('List Units'), array('controller' => 'units', 'action' => 'index'), array('class' => 'ajaxLink')); ?> </li>
		<li><?php echo $this->Html->link(__('New Unit'), array('controller' => 'units', 'action' => 'add'), array('class' => 'ajaxLink')); ?> </li>
            </ul>
        </div> 
</div>
<div class="ingredients index">
	<h2><?php echo __('Ingredients'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo $this->Paginator->sort('unit_id'); ?></th>
			<th><?php echo $this->Paginator->sort('solid'); ?></th>
			<th><?php echo $this->Paginator->sort('system'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($ingredients as $ingredient): ?>
	<tr>
		<td><?php echo h($ingredient['Ingredient']['name']); ?>&nbsp;</td>
		<td><?php echo h($ingredient['Ingredient']['description']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ingredient['Location']['name'], array('controller' => 'locations', 'action' => 'view', $ingredient['Location']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ingredient['Unit']['name'], array('controller' => 'units', 'action' => 'view', $ingredient['Unit']['id'])); ?>
		</td>
		<td><?php echo h($ingredient['Ingredient']['solid']); ?>&nbsp;</td>
		<td><?php echo h($ingredient['Ingredient']['system']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ingredient['User']['name'], array('controller' => 'users', 'action' => 'view', $ingredient['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $ingredient['Ingredient']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ingredient['Ingredient']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ingredient['Ingredient']['id']), null, __('Are you sure you want to delete # %s?', $ingredient['Ingredient']['id'])); ?>
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
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
