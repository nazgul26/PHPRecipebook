<script type="text/javascript">
    (function() {
        document.addEventListener("saved.preparationTime", function() {
            closeModal('editPrepTimeDialog');
            ajaxGet('preparation-times');
        });
    })();
</script>
<div class="preparationTimes index">
	<h2><?= __('Preparation Times') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Preparation Time'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editPrepTimeDialog')) ?>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($preparationTimes as $preparationTime): ?>
	<tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $preparationTime->id), array('class' => 'ajaxLink', 'targetId' => 'editPrepTimeDialog')) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $preparationTime->id), ['confirm' => __('Are you sure you want to delete {0}?', $preparationTime->name)]) ?>
        </td>
        <td><?= h($preparationTime->name) ?>&nbsp;</td>
	</tr>
    <?php endforeach; ?>
	</tbody>
	</table>
	<?= $this->element('pager') ?>
</div>
