<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Ingredients');
        
        $(document).off("savedIngredient.ingredients");
        $(document).on("savedIngredient.ingredients", function() {
            $('#editIngredientDialog').dialog('close');
            ajaxGet('ingredients');
        });
        
        $(document).on("saved.location", function() {
            $('#editLocationDialog').dialog('close');
            ajaxGet('ingredients');
        });
        
        $(document).on("saved.unit", function() {
            $('#editUnitDialog').dialog('close');
            ajaxGet('ingredients');
        });
        
    });
</script>
<div class="ingredients index">
	<h2><?php echo __('Ingredients'); ?></h2>
        <div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('Add Ingredient'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editIngredientDialog'));?></li>
            <li><button id="moreActionLinks">More Actions...</button></li>
	</ul>
        <div style="display: none;">
            <ul id="moreActionLinksContent">
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index'), array('class' => 'ajaxNavigationLink')); ?> </li>
		<li><?php echo $this->Html->link(__('Add Location'), array('controller' => 'locations', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editLocationDialog')); ?> </li>
		<li><?php echo $this->Html->link(__('List Units'), array('controller' => 'units', 'action' => 'index'), array('class' => 'ajaxNavigationLink')); ?> </li>
		<li><?php echo $this->Html->link(__('Add Unit'), array('controller' => 'units', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editUnitDialog')); ?> </li>
            </ul>
        </div> 
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
			<th><?php echo $this->Paginator->sort('name', null, array('direction' => 'asc', 'class' => 'ajaxLink')); ?></th>
			<th><?php echo $this->Paginator->sort('description', null, array('class' => 'ajaxLink')); ?></th>
			<th><?php echo $this->Paginator->sort('location_id', null, array('class' => 'ajaxLink')); ?></th>
			<th><?php echo $this->Paginator->sort('unit_id', null, array('class' => 'ajaxLink')); ?></th>
			
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
			<?php echo $this->Html->link($ingredient['Location']['name'], 
                                    array('controller' => 'locations', 'action' => 'edit', $ingredient['Location']['id']) , 
                                    array('class' => 'ajaxLink', 'targetId' => 'editLocationDialog')); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ingredient['Unit']['name'], 
                                array('controller' => 'units', 'action' => 'edit', $ingredient['Unit']['id']),
                                array('class' => 'ajaxLink', 'targetId' => 'editUnitDialog')); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')	));?>
        </p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('class' => 'ajaxLink'), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','class'=>'ajaxLink'));
		echo $this->Paginator->next(__('next') . ' >', array('class' => 'ajaxLink'), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
