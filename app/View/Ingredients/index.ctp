<div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('Add Ingredient'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editIngredientDialog'));?></li>
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
            <th class="actions"><?php echo __('Actions'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo $this->Paginator->sort('unit_id'); ?></th>
			
	</tr>
	<?php foreach ($ingredients as $ingredient): ?>
	<tr>
            		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ingredient['Ingredient']['id']), array('class' => 'ajaxLink', 'targetId' => 'editIngredientDialog')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ingredient['Ingredient']['id']), null, __('Are you sure you want to delete "%s"?', $ingredient['Ingredient']['name'])); ?>
		</td>
		<td><?php echo h($ingredient['Ingredient']['name']); ?>&nbsp;</td>
		<td><?php echo h($ingredient['Ingredient']['description']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ingredient['Location']['name'], array('controller' => 'locations', 'action' => 'view', $ingredient['Location']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ingredient['Unit']['name'], array('controller' => 'units', 'action' => 'view', $ingredient['Unit']['id'])); ?>
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
