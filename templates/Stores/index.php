
<div class="stores index">
    <h2><?= __('Stores') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('New Store'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm')) ?>
    </div>
    <table class="table table-hover table-striped align-middle">
    <thead>
    <tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stores as $store): ?>
    <tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $store->id)) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $store->id), ['confirm' => __('Are you sure you want to delete {0}}?', $store->name)]) ?>
        </td>
        <td><?= h($store->name) ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
	<?= $this->element('pager') ?>
</div>
