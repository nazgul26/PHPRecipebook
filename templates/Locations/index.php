<script type="text/javascript">
    onAppReady(function() {
        setSearchBoxTarget('Locations');

        document.addEventListener("saved.location", function() {
            closeModal('editLocationDialog');
            ajaxGet('locations');
        });
    });
</script>
<div class="locations index">
	<h2><?= __('Locations') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('New Location'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editLocationDialog')) ?>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($locations as $location): ?>
	<tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $location->id), ['class' => 'ajaxLink', 'targetId' => 'editLocationDialog']) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $location->id), ['confirm'=> __('Are you sure you want to delete "{0}"?', $location->name)]) ?>
        </td>
        <td><?= h($location->name) ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?= $this->element('pager') ?>
</div>
