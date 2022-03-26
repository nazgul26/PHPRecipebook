<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Ingredients');
        
        $(document).off("saved.ingredient");
        $(document).on("saved.ingredient", function() {
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
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ingredient->id), array('class' => 'ajaxLink', 'targetId' => 'editIngredientDialog')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ingredient->id), ['confirm' => __('Are you sure you want to delete "{0}"?', $ingredient->name)]); ?>
		</td>
		<td><?php echo h($ingredient->name); ?>&nbsp;</td>
		<td><?php echo h($ingredient->description); ?>&nbsp;</td>
		<td>
			<?php 
				if (isset($ingredient->location)) {
					echo $this->Html->link($ingredient->location->name, 
                                    array('controller' => 'locations', 'action' => 'edit', $ingredient->location->id) , 
                                    array('class' => 'ajaxLink', 'targetId' => 'editLocationDialog')); 
				}
				?>
		</td>
		<td>
			<?php 
				if (isset($ingredient->unit)) {
					echo $this->Html->link($ingredient->unit->name, 
                                array('controller' => 'units', 'action' => 'edit', $ingredient->unit->id),
                                array('class' => 'ajaxLink', 'targetId' => 'editUnitDialog')); 
				}?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?= $this->element('pager') ?>
</div>
