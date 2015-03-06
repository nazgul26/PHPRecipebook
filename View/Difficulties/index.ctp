<script type="text/javascript">
    $(function() {
        $(document).off("savedDifficulty.screen");
        $(document).on("savedDifficulty.screen", function() {
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
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $difficulty['Difficulty']['id']), array('class' => 'ajaxLink', 'targetId' => 'editDifficultyDialog')); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $difficulty['Difficulty']['id']), null, __('Are you sure you want to delete %s?', $difficulty['Difficulty']['name'])); ?>
            </td>
            <td><?php echo h($difficulty['Difficulty']['name']); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')	));?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

