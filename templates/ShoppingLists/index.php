<?php
use Cake\Routing\Router;
$baseUrl = Router::url('/');
$shoppingListId = isset($shoppingList->id) ? $shoppingList->id : "";
?>
<script type="text/javascript">
    onAppReady(function() {
        setSearchBoxTarget('Recipes');

        document.querySelector('[go-shopping]')?.addEventListener('click', function() {
            ajaxNavigate('<?= $baseUrl ?>ShoppingLists/select/<?= $shoppingListId ?>');
        });

        document.querySelector('[save-list]')?.addEventListener('click', function() {
            var form = document.querySelector('div.shoppingList form');
            if (form) form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
        });

        var recipeAC = document.getElementById('addRecipeAutocomplete');
        if (recipeAC) {
            initVanillaAutocomplete(recipeAC, {
                source: "<?= $baseUrl ?>Recipes/autoCompleteSearch",
                minLength: 1,
                autoFocus: true,
                select: function(event, ui) {
                    ajaxGet("<?= $baseUrl ?>ShoppingLists/addRecipe/<?= $shoppingListId ?>/" + ui.item.id + "/" + ui.item.servings);
                    recipeAC.value = '';
                    return false;
                }
            });
        }

        var ingredientAC = document.getElementById('addIngredientAutocomplete');
        if (ingredientAC) {
            initVanillaAutocomplete(ingredientAC, {
                source: "<?= $baseUrl ?>Ingredients/autoCompleteSearch",
                minLength: 1,
                autoFocus: true,
                select: function(event, ui) {
                    ajaxGet("<?= $baseUrl ?>ShoppingLists/addIngredient/<?= $shoppingListId ?>/" + ui.item.id);
                    ingredientAC.value = '';
                    return false;
                }
            });
        }

        document.querySelectorAll('input[name=searchType]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var selectedValue = document.querySelector('input[name=searchType]:checked').value;
                if (selectedValue == "recipe") {
                    ingredientAC.style.display = 'none';
                    recipeAC.style.display = '';
                    localStorage.setItem("shoppingListSearchType", "recipe");
                } else {
                    ingredientAC.style.display = '';
                    recipeAC.style.display = 'none';
                    localStorage.setItem("shoppingListSearchType", "ingredient");
                }
            });
        });

        document.querySelectorAll('input[type="fraction"]').forEach(function(inp) {
            inp.addEventListener('change', function() {
                fractionConvert(this, "<?= __("Entered value is not a number/fraction, please try again.") ?>");
            });
        });

        var searchType = localStorage.getItem("shoppingListSearchType");
        if (searchType == "ingredient") {
            var ingredientRadio = document.getElementById('ingredientSearch');
            if (ingredientRadio) ingredientRadio.checked = true;
        }

        var recipeRadio = document.getElementById('recipeSearch');
        if (recipeRadio) recipeRadio.dispatchEvent(new Event('change'));
    });
</script>

<?= $this->Flash->render() ?>

<h2><?= __('Shopping List') ?></h2>
<div class="actions-bar">
    <?= $this->Html->link(__('Clear List'), array('action' => 'clear'), array('class' => 'btn btn-outline-primary btn-sm ajaxLink')) ?>
    <?= $this->Html->link(__('List Stores'), array('controller' => 'stores', 'action' => 'index'), array('class' => 'btn btn-outline-primary btn-sm ajaxLink')) ?>
    <?= $this->Html->link(__('List Online Vendors'), array('controller' => 'vendors', 'action' => 'index'), array('class' => 'btn btn-outline-primary btn-sm ajaxLink')) ?>
</div>
<div class="shoppingList form">
<?= $this->Form->create($shoppingList) ?>
    <fieldset class="mb-3 p-3 bg-light rounded">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="form-check">
                <input type="radio" name="searchType" id="recipeSearch" value="recipe" class="form-check-input" checked/>
                <label for="recipeSearch" class="form-check-label"><?= __('Recipes') ?></label>
            </div>
            <div class="form-check">
                <input type="radio" name="searchType" id="ingredientSearch" value="ingredient" class="form-check-input"/>
                <label for="ingredientSearch" class="form-check-label"><?= __('Ingredients') ?></label>
            </div>
            <span class="fw-bold"><?= __('Search') ?></span>
            <input type="search" class="form-control form-control-sm" style="width: 300px;" id="addRecipeAutocomplete"/>
            <input type="search" class="form-control form-control-sm" style="width: 300px; display:none;" id="addIngredientAutocomplete"/>
        </div>
    </fieldset>

    <?php
    $recipeCount = count($shoppingList->shopping_list_recipes);
    if ($recipeCount > 0):?>
    <table class="table table-hover table-striped align-middle">
        <thead>
        <tr>
            <th><?= __('Action') ?></th>
            <th><?= __('Recipe Name') ?></th>
            <th><?= __('Servings') ?></th>
            <th><?= __('Servings to buy') ?></th>
        </tr>
        </thead>
        <tbody class="gridContent">
        <?php
        for ($mapIndex = 0; $mapIndex < $recipeCount; $mapIndex++) {
            $recipeName = $shoppingList->shopping_list_recipes[$mapIndex]->recipe->name;
            $recipeId = $shoppingList->shopping_list_recipes[$mapIndex]->recipe->id;
        ?>
        <tr>
            <td class="actions">
                <?= $this->Html->link(__('View'), array('controller' => 'recipes', 'action' => 'view', $recipeId), array('class' => 'ajaxLink')) ?>
                <?= $this->Html->link(__('Edit'), array('controller' => 'recipes', 'action' => 'edit', $recipeId), array('class' => 'ajaxLink')) ?>
                <?= $this->Html->link(__('Delete'), array('action' => 'deleteRecipe',
                        $shoppingListId,
                        $shoppingList->shopping_list_recipes[$mapIndex]['recipe_id']),
                        ['confirm' => __('Are you sure you want to remove %s?', $recipeName)]) ?>
                <?= $this->Form->hidden('shopping_list_recipes.' . $mapIndex . '.id') ?>
                <?= $this->Form->hidden('shopping_list_recipes.' . $mapIndex . '.recipe_id') ?>
                <?= $this->Form->hidden('shopping_list_recipes.' . $mapIndex . '.shopping_list_id') ?>
            </td>
            <td><?= $recipeName ?></td>
            <td><?= $shoppingList->shopping_list_recipes[$mapIndex]->recipe->serving_size ?></td>
            <td><?= $this->Form->control('shopping_list_recipes.' . $mapIndex . '.servings', array('label' => false)) ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php endif;?>

    <?php
    $ingredientCount = count($shoppingList->shopping_list_ingredients);
    if ($ingredientCount > 0):?>
    <table class="table table-hover table-striped align-middle">
        <thead>
        <tr>
            <th><?= __('Action') ?></th>
            <th><?= __('Quantity') ?></th>
            <th><?= __('Units') ?></th>
            <th><?= __('Qualifier') ?></th>
            <th><?= __('Ingredient Name') ?></th>
        </tr>
        </thead>
        <tbody class="gridContent">
        <?php for ($mapIndex = 0; $mapIndex < $ingredientCount; $mapIndex++) {
            $ingredientName = $shoppingList->shopping_list_ingredients[$mapIndex]->ingredient->name;
            $ingredientId = $shoppingList->shopping_list_ingredients[$mapIndex]->ingredient->id;
            $ingredientItemId = $shoppingList->shopping_list_ingredients[$mapIndex]->id;
        ?>
        <tr>
            <td class="actions">
                <?= $this->Html->link(__('Edit'), array('controller' => 'ingredients', 'action' => 'edit', $ingredientId), array('class' => 'ajaxLink')) ?>
                <?= $this->Html->link(__('Delete'), array('action' => 'deleteIngredient',
                   $shoppingList->id,
                   $ingredientItemId), array('class' => 'ajaxLink'),
                   __('Are you sure you want to remove %s?', $ingredientName)) ?>
            </td>
            <td>
                <?= $this->Form->hidden('shopping_list_ingredients.' . $mapIndex . '.id') ?>
                <?= $this->Form->hidden('shopping_list_ingredients.' . $mapIndex . '.shopping_list_id') ?>
                <?= $this->Form->hidden('shopping_list_ingredients.' . $mapIndex . '.ingredient_id') ?>
                <?= $this->Form->control('shopping_list_ingredients.' . $mapIndex . '.quantity', array('label' => false, 'type' => 'fraction')) ?></td>
            <td><?= $this->Form->control('shopping_list_ingredients.' . $mapIndex . '.unit_id', array('label' => false)) ?></td>
            <td><?= $this->Form->control('shopping_list_ingredients.' . $mapIndex . '.qualifier', array('label' => false, 'escape' => false)) ?></td>
            <td><?= $ingredientName ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php endif;?>

    <?php
        echo $this->Form->hidden('id');
        echo $this->Form->hidden('name');
    ?>
    <?= $this->Form->end() ?>
    <div class="d-flex gap-2 mt-3">
        <button class="btn btn-primary" save-list><i class="bi bi-save"></i> <?= __('Save') ?></button>
        <button class="btn btn-secondary" go-shopping><i class="bi bi-cart"></i> <?= __('Start Shopping') ?></button>
    </div>
</div>
