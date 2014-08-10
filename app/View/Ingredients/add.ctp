<script type="text/javascript">
    $(function() {
        $('.ingredients .submit').hide();
        
        $("#IngredientUSDAName").autocomplete({
            source: "CoreIngredients/search.json",
            minLength: 3,
            select: function(event, ui) {
                console.log(ui.item);
                if (ui.item.id) {
                    console.log('set it');
                    $("#IngredientCoreIngredientId").val(ui.item.id);
                    $("#USDA_name").val(ui.item.label);
                } else {
                    console.log('clear it');
                    $("#IngredientCoreIngredientId").val('');
                    $("#USDA_name").val('');
                }
            }
        });
    });
</script>
<div class="ingredients form">
<?php echo $this->Form->create('Ingredient', array('default' => false)); ?>
<?php
        echo $this->Form->input('name');
        echo $this->Form->input('description', array('escape' => true, 'rows' => '2', 'cols' => '10'));
        echo $this->Form->input('USDA_name');
        echo $this->Form->hidden('core_ingredient_id');
        echo $this->Form->input('location_id', array('label' => 'Location In Store'));
        echo $this->Form->input('unit_id', array('label' => 'Measurement Type'));
        echo $this->Form->input('solid', array('label' => 'Solid/Liquid', 'options' => array('1' => 'Yes', '2' => 'No')));
        echo $this->Form->hidden('system');
        echo $this->Form->hidden('user_id');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>