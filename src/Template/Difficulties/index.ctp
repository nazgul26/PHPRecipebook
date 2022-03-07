<script type="text/javascript">
    $(function() {
        $(document).off("saved.difficulty");
        $(document).on("saved.difficulty", function() {
            $('#editDifficultyDialog').dialog('close');
            ajaxGet('difficulties');
        });
    });
</script>
<div class="difficulties index">
	<h2><?php echo __('Difficulties'); ?></h2>
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Add Difficulty'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editDifficultyDialog')); ?></li>
            </ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>        
	</tr>
	<?php foreach ($difficulties as $difficulty): ?>
	<tr>
            <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $difficulty->id), array('class' => 'ajaxLink', 'targetId' => 'editDifficultyDialog')); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $difficulty->id), ['confirm' => __('Are you sure you want to delete {0}?', $difficulty->name)]); ?>
            </td>
            <td><?php echo h($difficulty->name); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
    <?= $this->element('pager') ?>
</div>

