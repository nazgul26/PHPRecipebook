<script type="text/javascript">
    $(function() {
        $('.coreIngredients .submit').hide();
    });
</script>
<div class="coreIngredients form">
<?php echo $this->Form->create('CoreIngredient', array('default' => false, 'targetId' => 'editCoreIngredientDialog')); ?>
    <?php
            echo $this->Form->input('id');
            echo $this->Form->input('groupNumber');
            echo $this->Form->input('description');
            echo $this->Form->input('short_description');
    ?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
