<div class="locations index">
	<h2><?php echo __('Locations'); ?></h2>
        <div class="actions">
            <ul>
                    <li><?php echo $this->Html->link(__('New Location'), array('action' => 'edit'), array('class' => 'ajaxLink', 'targetId' => 'editLocationDialog')); ?></li>
            </ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php echo __('Actions'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
	</tr>
	<?php foreach ($locations as $location): ?>
	<tr>
            <td class="actions">
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $location['Location']['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $location['Location']['id']), null, __('Are you sure you want to delete "%s"?', $location['Location']['name'])); ?>
            </td>
            <td><?php echo h($location['Location']['name']); ?>&nbsp;</td>

	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}')	));?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('class' => 'ajaxLink'), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','class'=>'ajaxLink'));
		echo $this->Paginator->next(__('next') . ' >', array('class' => 'ajaxLink'), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
