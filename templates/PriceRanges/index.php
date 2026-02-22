<script type="text/javascript">
    onAppReady(function() {
        document.addEventListener("saved.priceRange", function() {
            closeModal('editPriceRangesDialog');
            ajaxGet('price-ranges');
        });
    });
</script>

<div class="priceRanges index">
	<h2><?= __('Price Ranges') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('New Price Range'), array('action' => 'edit'), array('escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editPriceRangesDialog')) ?>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($priceRanges as $priceRange): ?>
	<tr>
        <td class="actions">
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $priceRange->id), array('class' => 'ajaxLink', 'targetId' => 'editPriceRangesDialog')) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $priceRange->id), ['confirm' => __('Are you sure you want to delete {0}?', $priceRange->name)]) ?>
        </td>
        <td><?= h($priceRange->name) ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?= $this->element('pager') ?>
</div>
