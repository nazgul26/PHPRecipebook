<?php 
use Cake\Routing\Router;

$baseUrl = Router::url('/');

?>
<script type="text/javascript">
    $(function() {
        $('.mealPlans .submit').hide();
        $('#editMealDialog').parent().find('.ui-dialog-title').html('Meal - <?php echo $mealDate;?>');
        
        $('#recipeAutocomplete').autocomplete({
            source: "<?php echo $baseUrl; ?>Recipes/autoCompleteSearch",
            minLength: 1,
            html: true,
            select: function(event, ui) {
                $('input[name="recipe_id"]').val(ui.item.id);
                $('input[name="servings"]').val(ui.item.servings);
                $('#recipeServingInfo').html("<?php echo __('recipe serves');?>: " + ui.item.servings).show();
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

<div class="mealPlans form">

<?php echo $this->Form->create($mealPlan, ['default' => false, 'targetId' => 'editMealDialog']); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('meal_name_id');
?>
 <div class="required">    
    <label for="recipeAutocomplete"><?php echo __('Recipe');?></label>
    <input type="text" 
           class="ui-widget" 
           id="recipeAutocomplete" 
           placeholder="<?php echo __('Enter Recipe Name');?>"
           value="<?php echo (isset($mealPlan->recipe->name) ? $mealPlan->recipe->name : "");?>"/>
    <div id="recipeServingInfo"></div>
</div>  
 
    <?php   
        echo $this->Form->hidden('recipe_id');
        echo $this->Form->input('mealday', ['default' => $mealPlan->mealday]);
        echo $this->Form->input('servings');
        echo $this->Form->input('days', array('default' => 1, 'type' => 'number'));
        echo $this->Form->input('skip', ['label' => __('Every other day'), 'type' => 'checkbox', 'default' => true, 'style' => 'margin: 0;']);
?>
    <?php if (isset($mealPlan->Recipe->id)):?>
    <div class="viewRecipe">
    <?php echo $this->Html->link(__('View'), array('controller'=>'recipes', 'action' => 'view', 
            $mealPlan->Recipe->id)); ?>
           <?php echo $this->Html->link(__('Edit'), array('controller'=>'recipes', 'action' => 'edit', 
            $mealPlan->Recipe->id)); ?>
    </div>  
    <?php endif;?>
 <?= $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end(); ?>
</div>
<?= $this->Flash->render() ?>


