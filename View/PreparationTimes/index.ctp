<script type="text/javascript">
    $(function() {
        $(document).off("savedPreparationTime.screen");
        $(document).on("savedPreparationTime.screen", function() {
            $('#editPrepTimeDialog').dialog('close');
            ajaxGet('preparation_times');
        });
    });
</script>
<div class="preparationTimes index">
	<h2><?php echo __('Preparation Times'); ?></h2>
        <div class="actions">
	<ul>
            <li><?php echo $this->Html->link(__('Add Preparation Time'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editPrepTimeDialog')); ?></li>
	</ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($preparationTimes as $preparationTime): ?>
	<tr>
            <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $preparationTime['PreparationTime']['id']), array('class' => 'ajaxLink', 'targetId' => 'editPrepTimeDialog')); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $preparationTime['PreparationTime']['id']), null, __('Are you sure you want to delete %s?', $preparationTime['PreparationTime']['name'])); ?>
            </td>
            <td><?php echo h($preparationTime['PreparationTime']['name']); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
