<?php 
$baseUrl = Router::url('/');
?>
<script type="text/javascript">
    $(function() {
        $('.mealPlans .submit').hide();
        
        $('#editMealDialog').parent().find('.ui-dialog-title').html('Meal - <?php echo $mealDate;?>');
        
        $('#recipeAutocomplete').autocomplete({
            source: "<?php echo $baseUrl; ?>Recipes/autoCompleteSearch.json",
            minLength: 1,
            html: true,
            select: function(event, ui) {
                $('#MealPlanRecipeId').val(ui.item.id);
                $('#MealPlanServings').val(ui.item.servings);
                $('#recipeServingInfo').html("<?php echo _('recipe serves: ');?>" + ui.item.servings).show();
                scaleServingsByDays();
            }
        });
        
        $('#MealPlanDays').change(scaleServingsByDays);
    });
    
    function scaleServingsByDays() {
        var days = $('#MealPlanDays').val();
        var servings = $('#MealPlanServings').val();
        var calculatedServings = servings/days;
        if (calculatedServings > 1) {
            $('#MealPlanServings').val(servings/days);
        } else {
            // Lets not go into decimal level servings
            $('#MealPlanServings').val(1);
        }
    }
</script>
<?php //echo $this->element('sql_dump'); ?>

<div class="mealPlans form">

<?php echo $this->Form->create('MealPlan', array('default' => false, 'targetId' => 'editMealDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->hidden('mealday', array('default' => $mealDate));
        echo $this->Form->input('meal_name_id');
?>
    
<div class="required">    
    <label for="recipeAutocomplete"><?php echo __('Recipe');?></label>
    <input type="text" 
           class="ui-widget" 
           id="recipeAutocomplete" 
           placeholder="<?php echo __('Enter Recipe Name');?>"
           value="<?php echo (isset($this->data['Recipe']['name']) ? $this->data['Recipe']['name'] : "");?>"/>
    <div id="recipeServingInfo"></div>
</div>  
 
    <?php   
        echo $this->Form->hidden('recipe_id');
        echo $this->Form->input('servings');
        echo $this->Form->input('days', array('default' => 1, 'type' => 'number'));
        echo $this->Form->input('skip', array('label' => __('Every other day'), 'type' => 'checkbox', 'default' => true));
?>
    <?php if (isset($this->data['Recipe']['id'])):?>
    <div class="viewRecipe">
    <?php echo $this->Html->link(__('View'), array('controller'=>'recipes', 'action' => 'view', 
            $this->request->data['Recipe']['id'])); ?>
           <?php echo $this->Html->link(__('Edit'), array('controller'=>'recipes', 'action' => 'edit', 
            $this->request->data['Recipe']['id'])); ?>
    </div>  
    <?php endif;?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>


