<script type="text/javascript">
    (function() {
        setSearchBoxTarget('Tags');

        document.addEventListener("saved.tag", function() {
            closeModal('editTagDialog');
            ajaxGet('tags');
        });
    })();
</script>
<div class="tags index">
	<h2><?= __('Tags') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Tag'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editTagDialog')) ?>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
		<th><?= $this->Paginator->sort('name', null, array('direction' => 'asc', 'class' => 'ajaxLink')) ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($tags as $tag): ?>
	<tr>
        <td class="actions">
			<?= $this->Html->link(__('Edit'), array('action' => 'edit', $tag->id), array('class' => 'ajaxLink', 'targetId' => 'editTagDialog')) ?>
			<?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $tag->id), ['confirm' => __('Are you sure you want to delete "{0}"?', $tag->name)]) ?>
		</td>
		<td><?= h($tag->name) ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?= $this->element('pager') ?>
</div>
