<script type="text/javascript">
    $(function() {
        $('.ethnicities .submit').hide();
    });
</script>
<div class="ethnicities form">
<?php echo $this->Form->create('Ethnicity', array('default' => false, 'targetId' => 'editIngredientDialog')); ?>
<?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo $this->Session->flash(); ?>
