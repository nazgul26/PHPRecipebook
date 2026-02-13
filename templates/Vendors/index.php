<div class="vendors index">
    <h2><?= __('Online Grocery Vendors') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('New Vendor'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm')) ?>
        <?= $this->Html->link(__('List Vendor Products'), array('controller' => 'vendor_products', 'action' => 'index'), array('class' => 'btn btn-outline-secondary btn-sm')) ?>
    </div>
    <table class="table table-hover table-striped align-middle">
    <thead>
    <tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
        <th><?= $this->Paginator->sort('home_url') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($vendors as $vendor): ?>
    <tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $vendor['Vendor']['id'])) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $vendor['Vendor']['id']), null, __('Are you sure you want to delete # %s?', $vendor['Vendor']['id'])) ?>
        </td>
        <td><?= h($vendor['Vendor']['name']) ?>&nbsp;</td>
        <td><?= h($vendor['Vendor']['home_url']) ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
	<?= $this->element('pager') ?>
</div>
