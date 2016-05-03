<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Recipes');
        
        $(document).on("saved.ethnicity", function() {
            $('#editEthnicityDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).on("saved.baseType", function() {
            $('#editBaseTypeDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).on("saved.course", function() {
            $('#editCourseDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("savedPreparationTime.recipes");
        $(document).on("savedPreparationTime.recipes", function() {
            $('#editPrepTimeDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("savedDifficulty.recipes");
        $(document).on("savedDifficulty.recipes", function() {
            $('#editDifficultyDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("savedSource.recipes");
        $(document).on("savedSource.recipes", function() {
            $('#editSourceDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("savedPreparationMethod.recipes");
        $(document).on("savedPreparationMethod.recipes", function() {
            $('#editPrepMethodDialog').dialog('close');
            ajaxGet('recipes');
        });
    });
</script>
<?php echo $this->Session->flash(); ?>
<div class="recipes index">
	<h2><?php echo __('Recipes'); ?></h2>
        <?php if ($loggedIn): ?>
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Add Recipe'), array('action' => 'edit'));?></li>
                <li><?php echo $this->Html->link(__('Find By Ingredient(s)'), array('action' => 'contains'), array('class' => 'ajaxNavigation'));?></li>
                <li><?php echo $this->Html->link(__('Import'), array('controller' => 'import')); ?></li>
                <li><button id="moreActionLinks">More Actions...</button></li>
            </ul>
            <div style="display: none;">
                <ul id="moreActionLinksContent">
                    <li><?php echo $this->Html->link(__('List Ethnicities'), array('controller' => 'ethnicities', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Ethnicity'), array('controller' => 'ethnicities', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editLocationDialog')); ?></li>
                    <li><?php echo $this->Html->link(__('List Base Types'), array('controller' => 'base_types', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Base Type'), array('controller' => 'base_types', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editBaseTypeDialog')); ?></li>
                    <li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Course'), array('controller' => 'courses', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editCourseDialog')); ?></li>
                    <li><?php echo $this->Html->link(__('List Preparation Times'), array('controller' => 'preparation_times', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Preparation Time'), array('controller' => 'preparation_times', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editPrepTimeDialog')); ?> </li>
                    <li><?php echo $this->Html->link(__('List Preparation Methods'), array('controller' => 'preparation_methods', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add Preparation Method'), array('controller' => 'preparation_methods', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editPrepMethodDialog')); ?> </li>
                    <li><?php echo $this->Html->link(__('List Difficulties'), array('controller' => 'difficulties', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add Difficulty'), array('controller' => 'difficulties', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editDifficultyDialog')); ?> </li>
                    <li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add Source'), array('controller' => 'sources', 'action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editSourceDialog')); ?> </li>
                    <li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index'), array('class' => 'ajaxNavigation')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add User'), array('controller' => 'users', 'action' => 'edit'), array('class' => 'ajaxLink')); ?> </li>
                </ul>
            </div> 
        </div>
        <?php endif;?>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('comments'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
			
	</tr>
	<?php foreach ($recipes as $recipe): ?>
	<tr>
            <td class="actions">
                <?php if (isset($recipe['Recipe']['private']) && $recipe['Recipe']['private'] == 'true' && $loggedInuserId != $recipe['User']['id'] && !$isEditor) {
                    echo __('(private)');
                } else {
                    echo $this->Html->link(__('View'), array('action' => 'view', $recipe['Recipe']['id']), array('class' => 'ajaxNavigation')); 
                }
                if ($loggedIn  && ($isAdmin || $loggedInuserId == $recipe['User']['id'])):?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recipe['Recipe']['id']), array('class' => 'ajaxNavigation')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recipe['Recipe']['id']), null, __('Are you sure you want to delete %s?', $recipe['Recipe']['name'])); ?>
                <?php endif;?>
            </td>
            <td><?php echo h($recipe['Recipe']['name']); ?>&nbsp;</td>
            <td><?php echo h($recipe['Recipe']['comments']); ?>&nbsp;</td>
            <td>
                <?php if ($isAdmin) {
                    echo $this->Html->link($recipe['User']['name'], array('controller' => 'users', 'action' => 'view', $recipe['User']['id']));
                } else {
                    echo $recipe['User']['name'];
                }?>
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
