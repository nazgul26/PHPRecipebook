
<script type="text/javascript">
    $(function() {
        $('.ingredients .submit').hide();    
    });
</script>

<div class="ingredients form">
<?php echo $this->Form->create('Ingredient', array('default' => false, 'targetId' => 'editIngredientDialog')); ?>
<?php
        echo $this->Form->input('id');
        echo $this->Form->input('name');
        echo $this->Form->input('description', array('escape' => true, 'rows' => '2', 'cols' => '10'));
        echo $this->Form->input('location_id', array('label' => __('Location In Store')));
        echo $this->Form->input('unit_id', array('label' => __('Measurement Type')));
        echo $this->Form->input('solid', array('label' => __('Solid/Liquid'), 'options' => array('1' => 'Yes', '2' => 'No')));
        echo $this->Form->hidden('system');
        echo $this->Form->hidden('user_id');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>