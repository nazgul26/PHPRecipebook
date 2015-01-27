<?php 
$baseUrl = Router::url('/');
?>
<script type="text/javascript">
    $(function() {
        //TODO: use localStorage to remember ingredient vs recipe search
        
        $('[go-shopping]').click(function() {
            ajaxNavigate('<?php echo $baseUrl;?>ShoppingLists/select');
        })
        
        $('#addRecipeAutocomplete').autocomplete({
            source: "<?php echo Router::url('/'); ?>Recipes/autoCompleteSearch.json",
            minLength: 1,
            html: true,
            select: function(event, ui) {
                ajaxGet("<?php echo Router::url('/'); ?>ShoppingLists/addRecipe/" + ui.item.id);
            }
        });
        
        $('#addIngredientAutocomplete').autocomplete({
            source: "<?php echo Router::url('/'); ?>Ingredients/autoCompleteSearch.json",
            minLength: 1,
            html: true,
            select: function(event, ui) {
                ajaxGet("<?php echo Router::url('/'); ?>ShoppingLists/addIngredient/" + ui.item.id);
            }
        });
        
        $("input[name=searchType]").change(function () {
            var selectedValue = $('input[name=searchType]:checked').val();
            if (selectedValue == "recipe") {
                $('#addIngredientAutocomplete').hide();
                $('#addRecipeAutocomplete').show();
            } else {
                $('#addIngredientAutocomplete').show();
                $('#addRecipeAutocomplete').hide();
            }
        });
        
        $('#recipeSearch').change(); // simulate change to setup
    });
    
</script>
<?php //echo $this->element('sql_dump'); ?>
<div class="shoppingList form">
<?php echo $this->Form->create('ShoppingList'); ?>
    <h2><?php echo __('Shopping List'); ?></h2>
    <div class="actions">
          <ul>
              <li><a href="#" id="saveAs"><?php echo __('Save as...');?></li>
              <li><?php echo $this->Html->link(__('Show Saved Lists'), array('action' => 'index')); ?></li>
          </ul>    
    </div>

    <fieldset class="addShoppingListItem">
        <input type="radio" name="searchType" id="recipeSearch" value="recipe" checked/><label for="recipeSearch">Recipes</label>
        <input type="radio" name="searchType" id="ingredientSearch" value="ingredient"/><label for="ingredientSearch">Ingredients</label>
        <span>Search</span>
        <input type="text" class="ui-widget" id="addRecipeAutocomplete"/>
        <input type="text" class="ui-widget" id="addIngredientAutocomplete"/>
    </div>
    
    <?php 
    $recipeCount = (isset($list) && isset($list['ShoppingListRecipe']) )? count($list['ShoppingListRecipe']) : 0; 
    if ($recipeCount > 0):?>
    <table>
        <tr class="headerRow">
            <th><?php echo __('Action');?></th>
            <th><?php echo __('Recipe Name');?></th>
            <th><?php echo __('Servings');?>
            <th><?php echo __('Scale By');?></th>
        </tr>
        <tbody class="gridContent">
        <?php 
        for ($mapIndex = 0; $mapIndex < $recipeCount; $mapIndex++) {
            $recipeName = $list['ShoppingListRecipe'][$mapIndex]['Recipe']['name'];
        ?>
        <tr>
            <td class="shoppingListText">
                <?php echo $this->Html->link(__('Delete'), array('action' => 'deleteRecipe', 
                    $list['ShoppingList']['id'],
                    $list['ShoppingListRecipe'][$mapIndex]['recipe_id']), array('class' => 'ajaxLink'),
                        __('Are you sure you want to remove %s?', $recipeName)); ?>
                
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.id'); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.recipe_id'); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.shopping_list_id'); ?>
            </td>
            <td class="shoppingListText shoppingListText-recipe"><?php echo $recipeName;?></td>
            <td class="shoppingListText"><?php echo $list['ShoppingListRecipe'][$mapIndex]['Recipe']['serving_size'];?></td>
            <td><?php echo $this->Form->input('ShoppingListRecipe.' . $mapIndex . '.scale', array('label' => false)); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php endif;?>
        
    <?php
    $ingredientCount = (isset($list) && isset($list['ShoppingListIngredient']))? count($list['ShoppingListIngredient']) : 0;
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
        $ingredientName = $list['ShoppingListIngredient'][$mapIndex]['Ingredient']['name'];
    ?>
    <tr>
        <td class="shoppingListText">
            <?php echo $this->Html->link(__('Delete'), array('action' => 'deleteIngredient', 
               $list['ShoppingList']['id'],
               $list['ShoppingListIngredient'][$mapIndex]['ingredient_id']), array('class' => 'ajaxLink'),
                   __('Are you sure you want to remove %s?', $ingredientName)); ?>
                
        </td>
        <td>
            <?php echo $this->Form->hidden('ShoppingListIngredient.' . $mapIndex . '.id'); ?>
            <?php echo $this->Form->hidden('ShoppingListIngredient.' . $mapIndex . '.shopping_list_id'); ?>
            <?php echo $this->Form->hidden('ShoppingListIngredient.' . $mapIndex . '.ingredient_id'); ?>

            <?php echo $this->Form->input('ShoppingListIngredient.' . $mapIndex . '.quantity', array('label' => false, 'type' => 'fraction')); ?></td>
        <td><?php echo $this->Form->input('ShoppingListIngredient.' . $mapIndex . '.unit_id', array('label' => false)); ?></td>
        <td><?php echo $this->Form->input('ShoppingListIngredient.' . $mapIndex . '.qualifier', array('label' => false, 'escape' => false)); ?></td>
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
        
    <button class="btn-primary">Save</button>
    <button class="btn-primary" go-shopping>Start Shopping</button>
    
    <?php echo $this->Form->end(); ?>
</div>
