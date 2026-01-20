<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Recipes');
        
        $(document).off("saved.ethnicity");
        $(document).on("saved.ethnicity", function() {
            $('#editEthnicityDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("saved.baseType");
        $(document).on("saved.baseType", function() {
            $('#editBaseTypeDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("saved.course");
        $(document).on("saved.course", function() {
            $('#editCourseDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("saved.preparationTime");
        $(document).on("saved.preparationTime", function() {
            $('#editPrepTimeDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("saved.difficulty");
        $(document).on("saved.difficulty", function() {
            $('#editDifficultyDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("saved.source");
        $(document).on("ssaved.source", function() {
            $('#editSourceDialog').dialog('close');
            ajaxGet('recipes');
        });
        
        $(document).off("saved.preparationMethod");
        $(document).on("saved.preparationMethod", function() {
            $('#editPrepMethodDialog').dialog('close');
            ajaxGet('recipes');
        });
    });
</script>

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
                    <li><?php echo $this->Html->link(__('List Ethnicities'), array('controller' => 'ethnicities', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Ethnicity'), array('controller' => 'ethnicities', 'action' => 'edit'), array('targetId' => 'editLocationDialog')); ?></li>
                    <li><?php echo $this->Html->link(__('List Base Types'), array('controller' => 'base_types', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Base Type'), array('controller' => 'base_types', 'action' => 'edit'), array( 'targetId' => 'editBaseTypeDialog')); ?></li>
                    <li><?php echo $this->Html->link(__('List Courses'), array('controller' => 'courses', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Course'), array('controller' => 'courses', 'action' => 'edit'), array('targetId' => 'editCourseDialog')); ?></li>
                    <li><?php echo $this->Html->link(__('List Preparation Times'), array('controller' => 'preparation_times', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link(__('Add Preparation Time'), array('controller' => 'preparation_times', 'action' => 'edit'), array('targetId' => 'editPrepTimeDialog')); ?> </li>
                    <li><?php echo $this->Html->link(__('List Preparation Methods'), array('controller' => 'preparation_methods', 'action' => 'index')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add Preparation Method'), array('controller' => 'preparation_methods', 'action' => 'edit'), array('targetId' => 'editPrepMethodDialog')); ?> </li>
                    <li><?php echo $this->Html->link(__('List Difficulties'), array('controller' => 'difficulties', 'action' => 'index')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add Difficulty'), array('controller' => 'difficulties', 'action' => 'edit'), array('targetId' => 'editDifficultyDialog')); ?> </li>
                    <li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add Source'), array('controller' => 'sources', 'action' => 'edit'), array('targetId' => 'editSourceDialog')); ?> </li>
                    <li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
                    <li><?php echo $this->Html->link(__('Add User'), array('controller' => 'users', 'action' => 'edit')); ?> </li>
                </ul>
            </div> 
        </div>
        <?php endif;?>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <?php if ($loggedIn) { ?>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <?php } ?>
			
	</tr>
	<?php foreach ($recipes as $recipe): ?>
	<tr>
            <td class="actions">
                <?php if (isset($recipe->private) && $recipe->private == 'true' && $loggedInuserId != $recipe->user->id && !$isEditor) {
                    echo __('(private)');
                } else {
                    echo $this->Html->link(__('View'), array('action' => 'view', $recipe->id), array('class' => 'ajaxNavigation')); 
                }
                if ($loggedIn  && ($isAdmin || $loggedInuserId == $recipe->user->id)):?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recipe->id), array('class' => 'ajaxNavigation')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recipe->id), ['confirm' => __('Are you sure you want to delete {0}?', $recipe->name)]); ?>
                <?php endif;?>
            </td>
            <td><?php echo h($recipe->name); ?>&nbsp;</td>
            <?php if ($loggedIn) { ?>
            <td>
                <?php if (isset($recipe->user)) {
                    if ($isAdmin) {
                        echo $this->Html->link($recipe->user->name, array('controller' => 'users', 'action' => 'edit', $recipe->user->id));
                    } else {
                        echo $recipe->user->name;
                    }
                } ?>
            </td>
            <?php } ?>
	</tr>
<?php endforeach; ?>
	</table>
    <?= $this->element('pager') ?>
</div>
