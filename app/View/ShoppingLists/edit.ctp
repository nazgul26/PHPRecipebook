<?php 
$baseUrl = Router::url('/');
?>
<script type="text/javascript">
    $(function() {
        initRowDelete();
        $('[go-shopping]').click(function() {
            ajaxNavigate('<?php echo $baseUrl;?>/ShoppingLists/select');
        })
    });
    
    function initRowDelete() {
        $('.deleteIcon').click(function() {
            if (confirm("<?php echo __("Are you sure you wish to remove this item?");?>")) {
                $(this).parent().parent().remove();
            }
        });
    }
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
        
        <div>
        <input type="radio" name="recipeSearch" value="recipe" checked/><label for="recipeSearch">Recipe</label>
        <input type="radio" name="ingredientSearch" value="ingredient"/><label for="ingredientSearch">Ingredient</label>
        <input type="text"/>
        <button class="btn btn-secondary">Add</button>
        </div>
        
    <table>
        <tr class="headerRow">
            <th><?php echo __('Delete');?></th>
            <th><?php echo __('Recipe Name');?></th>
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
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.id'); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.recipe_id'); ?>
                <?php echo $this->Form->hidden('ShoppingListRecipe.' . $mapIndex . '.shopping_list_id'); ?>
            </td>
            <td class="shoppingListText shoppingListText-recipe"><?php echo $list['ShoppingListRecipe'][$mapIndex]['Recipe']['name'];?></td>
            <td class="shoppingListText"><?php echo $list['ShoppingListRecipe'][$mapIndex]['Recipe']['serving_size'];?></td>
            <td><?php echo $this->Form->input('ShoppingListRecipe.' . $mapIndex . '.scale', array('label' => false)); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>


    <table>
    <tr class="headerRow">
        <th><?php echo __('Delete');?></th>
        <th><?php echo __('Quantity');?></th>
        <th><?php echo __('Units');?></th>
        <th><?php echo __('Qualifier');?></th>
        <th><?php echo __('Ingredient Name');?></th>
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
        <td class="shoppingListText shoppingListText-ingredient">
            <?php echo $list['ShoppingListIngredient'][$mapIndex]['Ingredient']['name'];?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
        </table>
    <?php
            echo $this->Form->hidden('id');
            echo $this->Form->hidden('name'); // Make dialog to change name
    ?>
        
    <button class="btn-primary">Save</button>
    <button class="btn-primary" go-shopping>Start Shopping</button>
    
    <?php echo $this->Form->end(); ?>

</div>
