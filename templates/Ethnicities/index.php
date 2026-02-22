<script type="text/javascript">
    onAppReady(function() {
        document.addEventListener("saved.ethnicity", function() {
            closeModal('editEthnicityDialog');
            ajaxGet('ethnicities');
        });
    });
</script>
<div class="ethnicities index">
    <h2><?= __('Ethnicities') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Ethnicity'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editEthnicityDialog')) ?>
    </div>
    <table class="table table-hover table-striped align-middle">
    <thead>
    <tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($ethnicities as $ethnicity): ?>
    <tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $ethnicity->id), array('class' => 'ajaxLink', 'targetId' => 'editEthnicityDialog')) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $ethnicity->id), ['confirm' => __('Are you sure you want to delete {0}?', $ethnicity->name)]) ?>
        </td>
        <td><?= h($ethnicity->name) ?>&nbsp;</td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    <?= $this->element('pager') ?>
</div>
