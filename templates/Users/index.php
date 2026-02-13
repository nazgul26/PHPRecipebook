<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users index">
    <h3><?= __('Users') ?></h3>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('New User'), ['action' => 'add'], ['escape' => false, 'class' => 'btn btn-primary btn-sm']) ?>
    </div>
    <table class="table table-hover table-striped align-middle">
        <thead>
            <tr>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('access_level') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                </td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->name) ?></td>
                <td><?= $this->Number->format($user->access_level) ?></td>
                <td><?= h($user->email) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<?= $this->element('pager') ?>
</div>
