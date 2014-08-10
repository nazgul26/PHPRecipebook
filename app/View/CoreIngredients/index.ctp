<div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('Add Core Ingredient'), array('action' => 'add'), array('class' => 'ajaxLink'));?></li>
            <li><?php echo $this->Html->link(__('List Ingredients'), array('controller' => 'ingredients', 'action' => 'index'), array('class' => 'ajaxLink'));?></li>
            <li><button id="moreActionLinks">More Actions...</button></li>
	</ul>
        <div style="display: none;">
            <ul id="moreActionLinksContent">
            </ul>
        </div> 
</div>
<div class="coreIngredients index">
	<h2><?php echo __('Core Ingredients'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th><?php echo $this->Paginator->sort('short_description'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($coreIngredients as $coreIngredient): ?>
	<tr>
		<td><?php echo h($coreIngredient['CoreIngredient']['name']); ?>&nbsp;</td>
		<td><?php echo h($coreIngredient['CoreIngredient']['short_description']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $coreIngredient['CoreIngredient']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $coreIngredient['CoreIngredient']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $coreIngredient['CoreIngredient']['id']), null, __('Are you sure you want to delete # %s?', $coreIngredient['CoreIngredient']['id'])); ?>
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
