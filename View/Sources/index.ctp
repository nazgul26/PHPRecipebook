<script type="text/javascript">
    $(function() {
        $(document).off("savedSource.screen");
        $(document).on("savedSource.screen", function() {
            $('#editSourceDialog').dialog('close');
            ajaxGet('sources');
        });
    });
</script>
<div class="sources index">
	<h2><?php echo __('Sources'); ?></h2>
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Add Source'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editSourceDialog')); ?></li>
            </ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('description'); ?></th>		
	</tr>
	<?php foreach ($sources as $source): ?>
	<tr>
            <td class="actions">
		<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $source['Source']['id']), array('class' => 'ajaxLink', 'targetId' => 'editSourceDialog')); ?>
		<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $source['Source']['id']), null, __('Are you sure you want to delete %s?', $source['Source']['name'])); ?>
            </td>
            <td><?php echo h($source['Source']['name']); ?>&nbsp;</td>
            <td><?php echo $source['Source']['description']; ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('class' => 'ajaxLink'), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','class'=>'ajaxLink'));
		echo $this->Paginator->next(__('next') . ' >', array('class' => 'ajaxLink'), null, array('class' => 'next disabled'));
	?>
	</div>
</div>