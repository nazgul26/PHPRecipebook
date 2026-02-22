<script type="text/javascript">
    onAppReady(function() {
        document.addEventListener("saved.preparationMethod", function() {
            closeModal('editPrepMethodDialog');
            ajaxGet('preparation-methods');
        });
    });
</script>
<div class="preparationMethods index">
	<h2><?= __('Preparation Methods') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Preparation Method'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editPrepMethodDialog')) ?>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($preparationMethods as $preparationMethod): ?>
	<tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $preparationMethod->id), ['class' => 'ajaxLink', 'targetId' => 'editPrepMethodDialog']) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $preparationMethod->id), ['confirm' => __('Are you sure you want to delete {0}?', $preparationMethod->name)]) ?>
        </td>
        <td><?= h($preparationMethod->name) ?>&nbsp;</td>
	</tr>
    <?php endforeach; ?>
	</tbody>
	</table>
	<?= $this->element('pager') ?>
</div>
