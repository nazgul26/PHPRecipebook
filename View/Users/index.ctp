<div class="users index">
	<h2><?= __('Users'); ?></h2>
        <div class="actions">
	<ul>
		<li><?= $this->Html->link(__('Add User'), array('action' => 'add')); ?></li>
	</ul>
        </div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?= __('Actions'); ?></th>
            <th><?= $this->Paginator->sort('username'); ?></th>
            <th><?= $this->Paginator->sort('name'); ?></th>
            <th><?= $this->Paginator->sort('email'); ?></th>
            <th><?= $this->Paginator->sort('access_level'); ?></th>
            <th><?= $this->Paginator->sort('last_login'); ?></th>
            <th><?= $this->Paginator->sort('created'); ?></th>
            <th><?= $this->Paginator->sort('modified'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
            <td class="actions">
                <?= $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
                <?= $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
                <?php
                    if ($user['User']['id'] != 1) {
                        echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); 
                    }
                ?>
            </td>
            <td><?= h($user['User']['username']); ?>&nbsp;</td>
            <td><?= h($user['User']['name']); ?>&nbsp;</td>
            <td><?= h($user['User']['email']); ?>&nbsp;</td>
            <td><?= h($user['User']['access_level']); ?>&nbsp;</td>
            <td><?= h($user['User']['last_login']); ?>&nbsp;</td>
            <td><?= h($user['User']['created']); ?>&nbsp;</td>
            <td><?= h($user['User']['modified']); ?>&nbsp;</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

