<script type="text/javascript">
    setSearchBoxTarget('Ingredients');

    document.addEventListener("saved.ingredient", function() {
        closeModal('editIngredientDialog');
        ajaxGet('ingredients');
    });

    document.addEventListener("saved.location", function() {
        closeModal('editLocationDialog');
        ajaxGet('ingredients');
    });

    document.addEventListener("saved.unit", function() {
        closeModal('editUnitDialog');
        ajaxGet('ingredients');
    });
</script>
<div class="ingredients index">
	<h2><?= __('Ingredients') ?></h2>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Ingredient'), ['action' => 'edit'], ['escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editIngredientDialog']) ?>
        <div class="dropdown d-inline-block">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear"></i> <?= __('Manage') ?>
            </button>
            <ul class="dropdown-menu">
                <li><?= $this->Html->link(__('List Locations'), ['controller' => 'locations', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
                <li><?= $this->Html->link('<i class="bi bi-plus me-1"></i>' . __('Add Location'), ['controller' => 'locations', 'action' => 'edit'], ['escape' => false, 'class' => 'dropdown-item ajaxLink', 'targetId' => 'editLocationDialog']) ?></li>
                <li><hr class="dropdown-divider"></li>
                <li><?= $this->Html->link(__('List Units'), ['controller' => 'units', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
                <li><?= $this->Html->link('<i class="bi bi-plus me-1"></i>' . __('Add Unit'), ['controller' => 'units', 'action' => 'edit'], ['escape' => false, 'class' => 'dropdown-item ajaxLink', 'targetId' => 'editUnitDialog']) ?></li>
            </ul>
        </div>
    </div>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name', null, array('direction' => 'asc', 'class' => 'ajaxLink')) ?></th>
        <th><?= $this->Paginator->sort('description', null, array('class' => 'ajaxLink')) ?></th>
        <th><?= $this->Paginator->sort('location_id', null, array('class' => 'ajaxLink')) ?></th>
        <th><?= $this->Paginator->sort('unit_id', null, array('class' => 'ajaxLink')) ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($ingredients as $ingredient): ?>
	<tr>
        <td class="actions">
			<?= $this->Html->link(__('Edit'), array('action' => 'edit', $ingredient->id), array('class' => 'ajaxLink', 'targetId' => 'editIngredientDialog')) ?>
			<?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $ingredient->id), ['confirm' => __('Are you sure you want to delete "{0}"?', $ingredient->name)]) ?>
		</td>
		<td><?= h($ingredient->name) ?>&nbsp;</td>
		<td><?= h($ingredient->description) ?>&nbsp;</td>
		<td>
			<?php
				if (isset($ingredient->location)) {
					echo $this->Html->link($ingredient->location->name,
                        array('controller' => 'locations', 'action' => 'edit', $ingredient->location->id),
                        array('class' => 'ajaxLink', 'targetId' => 'editLocationDialog'));
				}
			?>
		</td>
		<td>
			<?php
				if (isset($ingredient->unit)) {
					echo $this->Html->link($ingredient->unit->name,
                        array('controller' => 'units', 'action' => 'edit', $ingredient->unit->id),
                        array('class' => 'ajaxLink', 'targetId' => 'editUnitDialog'));
				}?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<?= $this->element('pager') ?>
</div>
