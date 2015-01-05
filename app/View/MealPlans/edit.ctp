<script type="text/javascript">
    $(function() {
        $('.mealPlans .submit').hide();
        
        $('#editMealDialog').parent().find('.ui-dialog-title').html('Meal - <?php echo $mealDate;?>');
    });
</script>
<div class="mealPlans form">

<?php echo $this->Form->create('MealPlan', array('default' => false, 'targetId' => 'editMealDialog')); ?>
<?php

        echo $this->Form->hidden('id');
        echo $this->Form->hidden('mealday', array('default' => $mealDate));
        echo $this->Form->input('meal_name_id');
        echo $this->Form->input('recipe_id');
        echo $this->Form->input('servings');
        echo $this->Form->input('days', array('default' => 1, 'type' => 'number'));
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>