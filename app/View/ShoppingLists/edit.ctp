<script type="text/javascript">
    $(function() {
        initRowDelete();
    });
    
    function initRowDelete() {
        $('.deleteIcon').click(function() {
            // TODO: if count of TR = 1 then just blank the row and re-number
            if (confirm("<?php echo __("Are you sure you wish to remove this item?");?>")) {
                $(this).parent().parent().remove();
            }
        });
    }
</script>
<div class="shoppingList form">
<?php echo $this->Form->create('ShoppingList'); ?>
    <fieldset>
        <legend><?php echo __('Shopping List'); ?></legend>
        <div class="actions">
              <ul>
                  <li><?php echo $this->Html->link(__('Show Saved Lists'), array('action' => 'index')); ?></li>
              </ul>    
        </div>
        
        <div>
        <input type="radio" name="recipeSearch" value="recipe" checked/><label for="recipeSearch">Recipe</label>
        <input type="radio" name="ingredientSearch" value="ingredient"/><label for="ingredientSearch">Ingredient</label>
        <input type="text"/>
        <button>Add</button>
        </div>
        
    <table>
        <tr class="headerRow">
            <th></th>
            <th><?php echo __('Recipes');?></th>
            <th><?php echo __('Servings');?>
            <th><?php echo __('Scale By');?></th>
        </tr>
        <tbody class="gridContent">
        <?php 
        $recipeCount = (isset($list) && isset($list['ShoppingListRecipe']) )? count($list['ShoppingListRecipe']) : 0;
        for ($mapIndex = 0; $mapIndex < $recipeCount; $mapIndex++) {
        ?>
        <tr>
            <td>
                <div class="ui-state-default ui-corner-all deleteIcon" title="<?php echo __('Delete'); ?>">
                    <span class="ui-icon ui-icon-trash"></span>
                </div>
            </td>
            <td>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.id'); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.recipe_id'); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.shopping_list_id'); ?>
                <?php echo $this->Form->input('ShoppingListRecipe.' . $mapIndex . 
                        '.Recipe.name', array('label' => false, 'escape' => false, 'type' => 'ui-widget')); ?></td>
            <td><?php echo $list['ShoppingListRecipe'][$mapIndex]['Recipe']['serving_size'];?></td>
            <td><?php echo $this->Form->input('ShoppingListRecipe.' . $mapIndex . '.scale', array('label' => false)); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>

    <table>
    <tr class="headerRow">
        <th colspan="2"><?php echo __('Ingredient Quantity');?></th>
        <th><?php echo __('Units');?></th>
        <th><?php echo __('Qualifier');?></th>
        <th><?php echo __('Ingredient');?></th>
    </tr>
    <tbody class="gridContent">
    <?php 
    $ingredientCount = (isset($list) && isset($list['ShoppingListIngredient']))? count($list['ShoppingListIngredient']) : 0;
    for ($mapIndex = 0; $mapIndex < $ingredientCount; $mapIndex++) {   
    ?>
    <tr>
        <td>
            <div class="ui-state-default ui-corner-all deleteIcon" title="<?php echo __('Delete'); ?>">
                <span class="ui-icon ui-icon-trash"></span>
            </div>
        </td>
        <td>
            <?php echo $this->Form->hidden('ShoppingListIngredient.' . $mapIndex . '.id'); ?>
            <?php echo $this->Form->hidden('ShoppingListIngredient.' . $mapIndex . '.shopping_list_id'); ?>
            <?php echo $this->Form->hidden('ShoppingListIngredient.' . $mapIndex . '.ingredient_id'); ?>

            <?php echo $this->Form->input('ShoppingListIngredient.' . $mapIndex . '.quantity', array('label' => false, 'type' => 'fraction')); ?></td>
        <td><?php echo $this->Form->input('ShoppingListIngredient.' . $mapIndex . '.unit_id', array('label' => false)); ?></td>
        <td><?php echo $this->Form->input('ShoppingListIngredient.' . $mapIndex . '.qualifier', array('label' => false, 'escape' => false)); ?></td>
        <td>
            <?php echo $this->Form->input('ShoppingListIngredient.' . $mapIndex . '.Ingredient.name', array('label' => false, 'escape' => false, 'type' => 'ui-widget')); ?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
        </table>
    <?php
            echo $this->Form->hidden('id');
            echo $this->Form->input('name');
    ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
    <button>Start Shopping</button>
</div>
