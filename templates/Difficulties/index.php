<script type="text/javascript">
    onAppReady(function() {
        document.addEventListener("saved.difficulty", function() {
            closeModal('editDifficultyDialog');
            ajaxGet('difficulties');
        });
    });
</script>
<div class="difficulties index">
	<h2><?= __('Difficulties') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Difficulty'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editDifficultyDialog')) ?>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($difficulties as $difficulty): ?>
	<tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $difficulty->id), array('class' => 'ajaxLink', 'targetId' => 'editDifficultyDialog')) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $difficulty->id), ['confirm' => __('Are you sure you want to delete {0}?', $difficulty->name)]) ?>
        </td>
        <td><?= h($difficulty->name) ?>&nbsp;</td>
	</tr>
    <?php endforeach; ?>
	</tbody>
	</table>
    <?= $this->element('pager') ?>
</div>
