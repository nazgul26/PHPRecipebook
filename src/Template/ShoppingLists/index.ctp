<?php 
use Cake\Routing\Router;

$baseUrl = Router::url('/');
$shoppingListId = isset($shoppingList->id) ? $shoppingList->id : "";
?>
<script type="text/javascript">
    $(function() {
        setSearchBoxTarget('Recipes');
        
        $('[go-shopping]').click(function() {
            ajaxNavigate('<?php echo $baseUrl;?>ShoppingLists/select/<?php echo $shoppingListId;?>');
        });

        $('[save-list]').click(function() {
            $('div.shoppingList').find('form').submit();
        });
        
        $('#addRecipeAutocomplete').autocomplete({
            source: "<?php echo $baseUrl; ?>Recipes/autoCompleteSearch",
            minLength: 1,
            html: true,
            select: function(event, ui) {
                ajaxGet("<?php echo $baseUrl; ?>ShoppingLists/addRecipe/<?php echo $shoppingListId;?>/" + ui.item.id + "/" + ui.item.servings);
            }
        });
        
        $('#addIngredientAutocomplete').autocomplete({
            source: "<?php echo $baseUrl; ?>Ingredients/autoCompleteSearch",
            minLength: 1,
            html: true,
            select: function(event, ui) {
                ajaxGet("<?php echo $baseUrl; ?>ShoppingLists/addIngredient/<?php echo $shoppingListId;?>/" + ui.item.id);
            }
        });
        
        $("input[name=searchType]").change(function () {
            var selectedValue = $('input[name=searchType]:checked').val();
            if (selectedValue == "recipe") {
                $('#addIngredientAutocomplete').hide();
                $('#addRecipeAutocomplete').show();
                localStorage.setItem("shoppingListSearchType", "recipe");
            } else {
                $('#addIngredientAutocomplete').show();
                $('#addRecipeAutocomplete').hide();
                localStorage.setItem("shoppingListSearchType", "ingredient");
            }
        });
        
        $('.fraction input').each(function() {
            $(this).change(function() {
                fractionConvert($(this), "<?php echo __("Entered value is not a number/fraction, please try again.");?>");
            });
        });
        
        var searchType = localStorage.getItem("shoppingListSearchType"); 
        if (searchType == "ingredient") {
            $('#ingredientSearch').prop('checked', true);
            $('#recipeSearch').removeAttr('checked');
        }
        
        $('#recipeSearch').change(); // simulate change to setup
    });
    
</script>

<?= $this->Flash->render() ?>

<h2><?php echo __('Shopping List'); ?></h2>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('Clear List'), array('action' => 'clear'), array('class' => 'ajaxLink')); ?> </li>
        <li><?php echo $this->Html->link(__('List Stores'), array('controller' => 'stores', 'action' => 'index'), array('class' => 'ajaxNavigationLink')); ?> </li>
        <li><?php echo $this->Html->link(__('List Online Vendors'), array('controller' => 'vendors', 'action' => 'index'), array('class' => 'ajaxNavigationLink')); ?> </li>
    </ul>
</div>
<div class="shoppingList form">
<?php echo $this->Form->create($shoppingList); ?>
    <fieldset class="addShoppingListItem">
        <input type="radio" name="searchType" id="recipeSearch" value="recipe" checked/><label for="recipeSearch">Recipes</label>
        <input type="radio" name="searchType" id="ingredientSearch" value="ingredient"/><label for="ingredientSearch">Ingredients</label>
        <span><?php echo __('Search');?></span>
        <input type="search" class="ui-widget" id="addRecipeAutocomplete"/>
        <input type="search" class="ui-widget" id="addIngredientAutocomplete"/>
    </fieldset>
    
    <?php 
    $recipeCount = count($shoppingList->shopping_list_recipes);
    if ($recipeCount > 0):?>
    <table>
        <tr class="headerRow">
            <th><?php echo __('Action');?></th>
            <th><?php echo __('Recipe Name');?></th>
            <th><?php echo __('Servings');?>
            <th><?php echo __('Servings to buy');?></th>
        </tr>
        <tbody class="gridContent">
        <?php 
        for ($mapIndex = 0; $mapIndex < $recipeCount; $mapIndex++) {
            $recipeName = $shoppingList->shopping_list_recipes[$mapIndex]->recipe->name;
            $recipeId = $shoppingList->shopping_list_recipes[$mapIndex]->recipe->id;
        ?>
        <tr>
            <td class="shoppingListText actions">
                <?php echo $this->Html->link(__('View'), array('controller' => 'recipes', 'action' => 'view', $recipeId), array('class' => 'ajaxNavigationLink')); ?>
                <?php echo $this->Html->link(__('Edit'), array('controller' => 'recipes', 'action' => 'edit', $recipeId), array('class' => 'ajaxNavigationLink')); ?>
                <?php echo $this->Html->link(__('Delete'), array('action' => 'deleteRecipe', 
                        $shoppingListId,
                        $shoppingList->shopping_list_recipes[$mapIndex]['recipe_id']), 
                        ['confirm' => __('Are you sure you want to remove %s?', $recipeName)]); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.id'); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.recipe_id'); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.shopping_list_id'); ?>
            </td>
            <td class="shoppingListText shoppingListText-recipe"><?php echo $recipeName;?></td>
            <td class="shoppingListText"><?php echo $shoppingList->shopping_list_recipes[$mapIndex]->recipe->serving_size;?></td>
            <td><?php echo $this->Form->control('ShoppingListRecipe.' . $mapIndex . '.servings', array('label' => false)); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php endif;?>
        
    <?php
    $ingredientCount = count($shoppingList->shopping_list_ingredients);
    if ($ingredientCount > 0):?>
    <table>
    <tr class="headerRow">
        <th><?php echo __('Action');?></th>
        <th><?php echo __('Quantity');?></th>
        <th><?php echo __('Units');?></th>
        <th><?php echo __('Qualifier');?></th>
        <th><?php echo __('Ingredient Name');?></th>
    </tr>
    <tbody class="gridContent">
    <?php for ($mapIndex = 0; $mapIndex < $ingredientCount; $mapIndex++) { 
        $ingredientName = $shoppingList->shopping_list_ingredients[$mapIndex]->ingredient->name;
        $ingredientId = $shoppingList->shopping_list_ingredients[$mapIndex]->ingredient->id;
        $ingredientItemId = $shoppingList->shopping_list_ingredients[$mapIndex]->id;
    ?>
    <tr>
        <td class="shoppingListText actions">
            <?php echo $this->Html->link(__('Edit'), array('controller' => 'ingredients', 'action' => 'edit', $ingredientId), array('class' => 'ajaxNavigationLink')); ?>
            <?php echo $this->Html->link(__('Delete'), array('action' => 'deleteIngredient', 
               $shoppingList->id,
               $ingredientItemId), array('class' => 'ajaxLink'),
                   __('Are you sure you want to remove %s?', $ingredientName)); ?>
                
        </td>
        <td>
            <?php echo $this->Form->hidden('shopping_list_ingredients.' . $mapIndex . '.id'); ?>
            <?php echo $this->Form->hidden('shopping_list_ingredients.' . $mapIndex . '.shopping_list_id'); ?>
            <?php echo $this->Form->hidden('shopping_list_ingredients.' . $mapIndex . '.ingredient_id'); ?>

            <?php echo $this->Form->control('shopping_list_ingredients.' . $mapIndex . '.quantity', array('label' => false, 'type' => 'fraction')); ?></td>
        <td><?php echo $this->Form->control('shopping_list_ingredients.' . $mapIndex . '.unit_id', array('label' => false)); ?></td>
        <td><?php echo $this->Form->control('shopping_list_ingredients.' . $mapIndex . '.qualifier', array('label' => false, 'escape' => false)); ?></td>
        <td class="shoppingListText shoppingListText-ingredient">
            <?php echo $ingredientName;?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
    </table>
    <?php endif;?>
        
    <?php
        echo $this->Form->hidden('id');
        echo $this->Form->hidden('name'); // Make dialog to change name
    ?>
    <?php echo $this->Form->end(); ?>
    <button class="btn-primary" save-list><?php echo __('Save');?></button>
    <button class="btn-primary" go-shopping><?php echo __('Start Shopping');?></button>
</div>
