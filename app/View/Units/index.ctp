<div class="units index">
	<h2><?php echo __('Units'); ?></h2>
        <div class="actions">
            <ul>
                    <li><?php echo $this->Html->link(__('New Unit'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editUnitDialog')); ?></li>
            </ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('abbreviation'); ?></th>
			<th><?php echo $this->Paginator->sort('system'); ?></th>
			<th><?php echo $this->Paginator->sort('sort_order'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($units as $unit): ?>
	<tr>
            <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $unit['Unit']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $unit['Unit']['id']), null, __('Are you sure you want to delete # %s?', $unit['Unit']['id'])); ?>
            </td>
            <td><?php echo h($unit['Unit']['id']); ?>&nbsp;</td>
            <td><?php echo h($unit['Unit']['name']); ?>&nbsp;</td>
            <td><?php echo h($unit['Unit']['abbreviation']); ?>&nbsp;</td>
            <td><?php echo h($unit['Unit']['system']); ?>&nbsp;</td>
            <td><?php echo h($unit['Unit']['sort_order']); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')));?>
        </p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('class' => 'ajaxLink'), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','class'=>'ajaxLink'));
		echo $this->Paginator->next(__('next') . ' >', array('class' => 'ajaxLink'), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
