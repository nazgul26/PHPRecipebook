<script type="text/javascript">
    setSearchBoxTarget('Recipes');

    document.addEventListener("saved.ethnicity", function() {
        closeModal('editEthnicityDialog');
        ajaxGet('recipes');
    });

    document.addEventListener("saved.baseType", function() {
        closeModal('editBaseTypeDialog');
        ajaxGet('recipes');
    });

    document.addEventListener("saved.course", function() {
        closeModal('editCourseDialog');
        ajaxGet('recipes');
    });

    document.addEventListener("saved.preparationTime", function() {
        closeModal('editPrepTimeDialog');
        ajaxGet('recipes');
    });

    document.addEventListener("saved.difficulty", function() {
        closeModal('editDifficultyDialog');
        ajaxGet('recipes');
    });

    document.addEventListener("saved.source", function() {
        closeModal('editSourceDialog');
        ajaxGet('recipes');
    });

    document.addEventListener("saved.preparationMethod", function() {
        closeModal('editPrepMethodDialog');
        ajaxGet('recipes');
    });
</script>

<div class="recipes index">
	<h2><?= __('Recipes') ?></h2>
        <?php if ($loggedIn): ?>
        <div class="actions-bar">
            <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Recipe'), ['action' => 'edit'], ['escape' => false, 'class' => 'btn btn-primary btn-sm']) ?>
            <?= $this->Html->link('<i class="bi bi-search"></i> ' . __('Find By Ingredient(s)'), ['action' => 'contains'], ['escape' => false, 'class' => 'btn btn-outline-primary btn-sm ajaxNavigation']) ?>
            <?= $this->Html->link('<i class="bi bi-download"></i> ' . __('Import'), ['controller' => 'import'], ['escape' => false, 'class' => 'btn btn-outline-primary btn-sm']) ?>

            <div class="dropdown d-inline-block">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-gear"></i> <?= __('Manage') ?>
                </button>
                <ul class="dropdown-menu manage-dropdown">
                    <li><h6 class="dropdown-header"><i class="bi bi-tag me-1"></i><?= __('Classification') ?></h6></li>
                    <li><?= $this->Html->link(__('Ethnicities'), ['controller' => 'ethnicities', 'action' => 'index'], ['class' => 'dropdown-item ajaxNavigation']) ?></li>
                    <li><?= $this->Html->link(__('Base Types'), ['controller' => 'base_types', 'action' => 'index'], ['class' => 'dropdown-item ajaxNavigation']) ?></li>
                    <li><?= $this->Html->link(__('Courses'), ['controller' => 'courses', 'action' => 'index'], ['class' => 'dropdown-item ajaxNavigation']) ?></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header"><i class="bi bi-clock me-1"></i><?= __('Preparation') ?></h6></li>
                    <li><?= $this->Html->link(__('Preparation Times'), ['controller' => 'preparation_times', 'action' => 'index'], ['class' => 'dropdown-item ajaxNavigation']) ?></li>
                    <li><?= $this->Html->link(__('Preparation Methods'), ['controller' => 'preparation_methods', 'action' => 'index'], ['class' => 'dropdown-item ajaxNavigation']) ?></li>
                    <li><?= $this->Html->link(__('Difficulties'), ['controller' => 'difficulties', 'action' => 'index'], ['class' => 'dropdown-item ajaxNavigation']) ?></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header"><i class="bi bi-journal me-1"></i><?= __('Other') ?></h6></li>
                    <li><?= $this->Html->link(__('Sources'), ['controller' => 'sources', 'action' => 'index'], ['class' => 'dropdown-item ajaxNavigation']) ?></li>
                    <li><?= $this->Html->link(__('Users'), ['controller' => 'users', 'action' => 'index'], ['class' => 'dropdown-item ajaxNavigation']) ?></li>
                </ul>
            </div>
        </div>
        <?php endif;?>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
            <th class="actions"><?= __('Actions') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <?php if ($loggedIn) { ?>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($recipes as $recipe): ?>
	<tr>
            <td class="actions">
                <?php if (isset($recipe->private) && $recipe->private == 'true' && $loggedInuserId != $recipe->user->id && !$isEditor) {
                    echo __('(private)');
                } else {
                    echo $this->Html->link(__('View'), array('action' => 'view', $recipe->id), array('class' => 'ajaxNavigation'));
                }
                if ($loggedIn  && ($isAdmin || $loggedInuserId == $recipe->user->id)):?>
                    <?= $this->Html->link(__('Edit'), array('action' => 'edit', $recipe->id), array('class' => 'ajaxNavigation')) ?>
                    <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $recipe->id), ['confirm' => __('Are you sure you want to delete {0}?', $recipe->name)]) ?>
                <?php endif;?>
            </td>
            <td><?= h($recipe->name) ?>&nbsp;</td>
            <?php if ($loggedIn) { ?>
            <td>
                <?php if (isset($recipe->user)) {
                    if ($isAdmin) {
                        echo $this->Html->link($recipe->user->name, array('controller' => 'users', 'action' => 'edit', $recipe->user->id));
                    } else {
                        echo $recipe->user->name;
                    }
                } ?>
            </td>
            <?php } ?>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
    <?= $this->element('pager') ?>
</div>
