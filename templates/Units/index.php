<script type="text/javascript">
    onAppReady(function() {
        document.addEventListener("saved.unit", function() {
            closeModal('editUnitDialog');
            ajaxGet('units');
        });
    });
</script>
<div class="units index">
    <h2><?= __('Units') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Unit'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editUnitDialog')) ?>
    </div>
    <table class="table table-hover table-striped align-middle">
    <thead>
    <tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
        <th><?= $this->Paginator->sort('abbreviation') ?></th>
        <th><?= $this->Paginator->sort('system_type') ?></th>
        <th><?= $this->Paginator->sort('sort_order') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($units as $unit): ?>
    <tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $unit->id), array('class' => 'ajaxLink', 'targetId' => 'editUnitDialog')) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $unit->id), ['confirm' => __('Are you sure you want to delete {0}?', $unit->name)]) ?>
        </td>
        <td><?= h($unit->name) ?>&nbsp;</td>
        <td><?= h($unit->abbreviation) ?>&nbsp;</td>
        <td><?= h($unit->system_type) ?>&nbsp;</td>
        <td><?= h($unit->sort_order) ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
	<?= $this->element('pager') ?>
</div>
