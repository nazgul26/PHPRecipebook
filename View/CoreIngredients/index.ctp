<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('CoreIngredients');
        
        $(document).on("saved.coreIngredient", function() {
            $('#editCoreIngredientDialog').dialog('close');
            ajaxGet('CoreIngredients');
        }); 
    });
</script>
<div class="coreIngredients index">
	<h2><?php echo __('Core Ingredients'); ?></h2>
            <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Add Core Ingredient'), array('action' => 'edit'), array('class' => 'ajaxNavigationLink'));?></li>
                <li><?php echo $this->Html->link(__('List Ingredients'), array('controller' => 'ingredients', 'action' => 'index'), array('class' => 'ajaxNavigationLink'));?></li>
                <li><button id="moreActionLinks">More Actions...</button></li>
            </ul>
            <div style="display: none;">
                <ul id="moreActionLinksContent">
                </ul>
            </div> 
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name', null, array('class' => 'ajaxLink')); ?></th>
            <th><?php echo $this->Paginator->sort('short_description', null, array('class' => 'ajaxLink')); ?></th>  
	</tr>
	<?php foreach ($coreIngredients as $coreIngredient): ?>
	<tr>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $coreIngredient['CoreIngredient']['id']), array('class' => 'ajaxLink', 'targetId' => 'editCoreIngredientDialog')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $coreIngredient['CoreIngredient']['id']), null, __('Are you sure you want to delete # %s?', $coreIngredient['CoreIngredient']['id'])); ?>
            </td>
            <td><?php echo h($coreIngredient['CoreIngredient']['name']); ?>&nbsp;</td>
            <td><?php echo h($coreIngredient['CoreIngredient']['short_description']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('class' => 'ajaxLink'), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','class'=>'ajaxLink'));
		echo $this->Paginator->next(__('next') . ' >', array('class' => 'ajaxLink'), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
