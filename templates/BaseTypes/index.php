<script type="text/javascript">
    (function() {
        document.addEventListener("saved.baseType", function() {
            closeModal('editBaseTypeDialog');
            ajaxGet('BaseTypes');
        });
    })();
</script>
<div class="baseTypes index">
	<h2><?= __('Base Types') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Base Type'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editBaseTypeDialog')) ?>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($baseTypes as $baseType): ?>
	<tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $baseType->id), array('class' => 'ajaxLink', 'targetId' => 'editBaseTypeDialog')) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $baseType->id], ['confirm' => __('Are you sure you want to delete {0}?', $baseType->name)]) ?>
        </td>
        <td><?= h($baseType->name) ?>&nbsp;</td>
	</tr>
    <?php endforeach; ?>
	</tbody>
	</table>
    <?= $this->element('pager') ?>
</div>
