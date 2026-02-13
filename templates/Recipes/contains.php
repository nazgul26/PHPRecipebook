<?php
use Cake\Routing\Router;
$baseUrl = Router::url('/');
?>

<script type="text/javascript">
    (function() {
        setSearchBoxTarget('Recipes');

        var acInput = document.getElementById('addIngredientAutocomplete');
        if (acInput) {
            initVanillaAutocomplete(acInput, {
                source: "<?= $baseUrl ?>Ingredients/autoCompleteSearch",
                minLength: 1,
                select: function(event, ui) {
                    var placeholder = document.getElementById('placeHolderRow');
                    if (placeholder) placeholder.style.display = 'none';
                    var gridContent = document.querySelector('.gridContent');
                    if (gridContent) {
                        var tr = document.createElement('tr');
                        tr.innerHTML = '<td>' + ui.item.value + '<input type="hidden" name="data[]" value="' + ui.item.id + '"/></td>';
                        gridContent.appendChild(tr);
                    }
                    acInput.value = '';
                    return false;
                }
            });
        }

        document.querySelectorAll('[clear-list]').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                var rows = document.querySelectorAll('.gridContent > tr');
                rows.forEach(function(row) { row.remove(); });
            });
        });
    })();
</script>
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Recipes'), array('action' => 'index'), array('class' => 'ajaxNavigation')) ?></li>
    <li class="breadcrumb-item active"><?= __('Find By Ingredient(s)') ?></li>
</ol>
</nav>

<h2><?= __('Enter the ingredients') ?></h2>
<div class="containsForm form">
<?= $this->Form->create($shoppingList) ?>
    <fieldset class="addShoppingListItem">
        <span><?= __('Search') ?></span>
        <input type="text" class="form-control" id="addIngredientAutocomplete"/>
    </fieldset>

    <table class="table table-hover align-middle">
        <thead>
        <tr>
            <th><?= __('Ingredient Name') ?></th>
        </tr>
        </thead>
        <tbody class="gridContent">
            <tr id="placeHolderRow">
                <td><i><?= __('No ingredients selected') ?></i></td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex gap-2">
        <button class="btn btn-primary"><?= __('Search') ?></button>
        <a href="#" clear-list class="btn btn-outline-secondary"><?= __('Clear') ?></a>
    </div>

</form>

<?php if (isset($recipes)) :?>
<br/>

<h3><?= __('Recipes found') ?></h3>
<hr/>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <th class="actions"><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('name') ?></th>
        <th><?= __('# of Matches') ?></th>
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
        <td><?= $recipe->matches ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>
